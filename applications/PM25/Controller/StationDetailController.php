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
                        'pm25'  =>   'PM2.5',
                        'pm10'  =>   'PM10',
                        'o3'    =>   'O3',
                        'no2'   =>   'NO2',
                        'co'    =>   'CO',
                        'so2'   =>   'SO2',
                    ];

                    $summaryItems = [];

                    foreach($enabledSummary as $summaryIdentifier) {
                        switch($summaryIdentifier) {
                            case 'today':
                                $summaryItems[] = SummaryDefinition::createOneDaySummary(
                                    $summaryIdentifier, 'Today',
                                    new DateTime(date('Y-m-d')),
                                    $summaryAttributes,
                                    24,
                                    'HOUR');
                            break;
                            case 'yesterday':
                                $summaryItems[] = SummaryDefinition::createOneDaySummary(
                                    $summaryIdentifier, 'Yesterday',
                                    (new DateTime(date('Y-m-d')))->sub(new DateInterval('P1D')),
                                    $summaryAttributes,
                                    24,
                                    'HOUR');
                            break;
                            case '7days':
                                $summaryItems[] = SummaryDefinition::createDateRangeSummary(
                                    $summaryIdentifier, '7 Days',
                                    (new DateTime(date('Y-m-d')))->sub(new DateInterval('P7D')),
                                    (new DateTime(date('Y-m-d'))),
                                    $summaryAttributes,
                                    'DAY');
                            break;
                            case '30days':
                                $summaryItems[] = SummaryDefinition::createDateRangeSummary(
                                    $summaryIdentifier, '30 Days',
                                    (new DateTime(date('Y-m-d')))->sub(new DateInterval('P30D')),
                                    (new DateTime(date('Y-m-d'))),
                                    $summaryAttributes,
                                    'DAY');
                            break;
                        }
                    }

                    $predicateStation = new Predicate('m.station_id = :station' , [ ':station' => $stationId ]);

                    foreach ($summaryItems as $summaryItem) {

                        $summarySection = [
                            'title' => $summaryItem->title,
                            'identifier' => $summaryItem->identifier,
                            'range' => $summaryItem->getRangeInfo(),
                        ];

                        $predicateDateRange = $summaryItem->createDateRangePredicate();
                        $conditionSql = Predicate::mergePredicateConditions([$predicateStation, $predicateDateRange]);
                        $commonQueryArguments = Predicate::mergePredicateArguments([$predicateStation, $predicateDateRange]);

                        foreach($summaryItem->attributes as $field => $label) {
                            // $field = StatsUtils::canonicalizeFieldName($label);

                            $stm = $conn->prepareAndExecute("SELECT MAX(m.$field), MIN(m.$field), AVG(m.$field) FROM measures m WHERE $conditionSql",$commonQueryArguments);
                            $result = $stm->fetch(PDO::FETCH_NUM);
                            $max = doubleval($result[0]);
                            $min = doubleval($result[1]);
                            $avg = doubleval($result[2]);

                            // print_r($conditionSql);
                            // print_r($commonQueryArguments);
                            $stm = $conn->prepareAndExecute("SELECT m.$field FROM measures m WHERE $conditionSql ORDER BY m.published_at DESC LIMIT 1",$commonQueryArguments);
                            $last = doubleval($stm->fetchColumn(0));

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
                                'chart' => 'area',
                                'data' => [
                                    'max' => $max,
                                    'min' => $min,
                                    'last' => $last,
                                    'avg'  => $avg,
                                    'series' => $all,
                                ],
                            ];
                            if (isset($summaryItem->units[$field])) {
                                $summary['unit'] = $summaryItem->units[$field];
                            }
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
