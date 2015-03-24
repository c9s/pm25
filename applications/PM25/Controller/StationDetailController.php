<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\Station;
use PM25\Model\StationCollection;
use PM25\Model\MeasureCollection;
use LazyRecord\ConnectionManager;
use LazyRecord\Connection;
use PDO;
use PDOStatement;
use LogicException;
use DateTime;
use DateInterval;
use PM25\StatsUtils;
use PM25\Predicate;
use PM25\SummaryDefinition;

class StationDetailController extends Controller
{
    public $useCache = false;

    public function getDefaultConnection() {
        static $conn;
        if ($conn) {
            return $conn;
        }
        $conns = ConnectionManager::getInstance();
        return $conn = $conns->get('default');
    }

    public function indexAction($id) {
        $enableMeasurementsArray = $this->request->param('measurements');
        if ($enableMeasurementsArray === NULL) {
            $enableMeasurementsArray = 1;
        }
        $enabledSummaryStr = $this->request->param('summary');
        if ($enabledSummaryStr == "1") {
            $enabledSummaryStr = 'today,yesterday,7days';
        }
        $enabledSummary = array_map('trim',explode(',', $enabledSummaryStr));

        $station = new Station;
        if (is_numeric($id)) {
            $station->load(intval($id));
        } else {
            $stations = new StationCollection;
            $stations->where()
                ->equal('name', $id)
                ->or()
                ->equal('city', $id);
            $station = $stations->first();
        }
        if ($station && $station->id) {
            $data = $station->toArray();

            // clean up un-serializable fields
            unset($data['location']);

            $stationId = $station->id;

            if ($enableMeasurementsArray) {
                $measurements = array();
                $measures = new MeasureCollection;
                $measures->where()
                    ->equal('station_id', $stationId);
                $measures->order('published_at', 'DESC');
                $measures->limit(36);
                foreach($measures as $measure) {
                    $array = $measure->toArray();
                    unset($array['station_id']);
                    $measurements[] = $array;
                }

                // register measurements data to the json object
                $data['measurements']  = $measurements;
            }
            if ($enabledSummary && !empty($enabledSummary)) {
                if ($this->useCache) {
                    $json = apc_fetch("station-detail-$stationId-$enabledSummaryStr");
                    if ($json) {
                        header('Content-Type: application/json;');
                        return $json;
                    }
                }


                if ($conn = $this->getDefaultConnection()) {

                    // Use attributes to generate the summary fields
                    // $attributes = $station->measure_attributes;
                    // print_r($attributes->toArray());
                    $summaryAttributes = [
                        'PM2.5' => 'pm25',
                        'PM10' => 'pm10',
                        'O3' => 'o3', 
                        'NO2' => 'no2',
                        'CO' => 'co', 
                        'SO2' => 'so2',
                    ];

                    $summaryItems = [];

                    foreach($enabledSummary as $summaryIdentifier) {
                        switch($summaryIdentifier) {
                            case 'today':
                                $summaryItems[] = SummaryDefinition::createOneDaySummary(
                                    $summaryIdentifier,
                                    new DateTime(date('Y-m-d')),
                                    $summaryAttributes,
                                    24,
                                    'HOUR');
                            break;
                            case 'yesterday':
                                $summaryItems[] = SummaryDefinition::createOneDaySummary(
                                    $summaryIdentifier,
                                    (new DateTime(date('Y-m-d')))->sub(new DateInterval('P1D')),
                                    $summaryAttributes,
                                    24,
                                    'HOUR');
                            break;
                            case '7days':
                                $summaryItems[] = SummaryDefinition::createDateRangeSummary(
                                    $summaryIdentifier,
                                    (new DateTime(date('Y-m-d')))->sub(new DateInterval('P7D')),
                                    (new DateTime(date('Y-m-d'))),
                                    $summaryAttributes,
                                    'DAY');
                            break;
                            break;
                        }
                    }

                    $predicateStation = new Predicate('m.station_id = :station' , [ ':station' => $stationId ]);

                    foreach ($summaryItems as $summaryItem) {

                        $summarySection = [
                            'identifier' => $summaryItem->identifier,
                            'range' => $summaryItem->getRangeInfo(),
                        ];

                        $predicateDateRange = $summaryItem->createDateRangePredicate();
                        $conditionSql = StatsUtils::mergePredicateConditions([$predicateStation, $predicateDateRange]);
                        $commonQueryArguments = StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]);

                        foreach($summaryItem->attributes as $label) {
                            $field = StatsUtils::canonicalizeFieldName($label);


                            $stm = $conn->prepareAndExecute("SELECT MAX(m.$field), MIN(m.$field), AVG(m.$field) FROM measures m WHERE $conditionSql",$commonQueryArguments);
                            $max = doubleval($stm->fetchColumn(0));
                            $min = doubleval($stm->fetchColumn(1));
                            $avg = doubleval($stm->fetchColumn(2));

                            $stm = $conn->prepareAndExecute("SELECT m.$field FROM measures m WHERE $conditionSql ORDER BY m.published_at DESC LIMIT 1",$commonQueryArguments);
                            $now = doubleval($stm->fetchColumn(0));

                            $datePaddingSql = $summaryItem->generateDatePaddingTableSql();

                            $seriesSql = "SELECT {$summaryItem->groupByMethod}(m.$field), " . StatsUtils::generateDateRowGroupBy($summaryItem->unit) . " AS group_date FROM measures AS m";
                            $seriesSql .= " RIGHT JOIN $datePaddingSql ON (" . StatsUtils::generateDatePaddingTableJoinCondition($summaryItem->unit) . " AND $conditionSql)";
                            $seriesSql .= " GROUP BY " . StatsUtils::generateDateRowGroupBy($summaryItem->unit);
                            $seriesSql .= " ORDER BY date_rows.published_at ";

                            // StatsUtils::sqlDebug($conn, $seriesSql, StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));

                            
                            $stm = $conn->prepareAndExecute($seriesSql, $commonQueryArguments);
                            $all = StatsUtils::fetchSeries($stm);

                            $summary = [
                                'label' => $label,
                                'field' => $field,
                                'unit' => 'ug/m3',
                                'chart' => 'area',
                                'data' => [
                                    'max' => $max,
                                    'min' => $min,
                                    'now' => $now,
                                    'avg' => $avg,
                                    'series' => $all,
                                ],
                            ];
                            $summarySection['rows'][] = $summary;
                        }
                        $data['summary'][] = $summarySection;
                    }
                }
            }
            $json = $this->toJson($data);
            apc_store("station-detail-$stationId-$enabledSummaryStr", $json, 60 * 10);
            return $json;

        } else {
            return $this->toJson([ 'error' => 'Station not found' ]);
        }
    }
}
