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
        $enabledSummary = $this->request->param('summary');
        if ($enabledSummary == "1") {
            $enabledSummary = 'today,yesterday,7days';
        }
        $enabledSummary = explode(',', $enabledSummary);

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

            if ($enableMeasurementsArray) {
                $measurements = array();
                $measures = new MeasureCollection;
                $measures->where()
                    ->equal('station_id', $station->id);
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

                    foreach($enabledSummary as $summaryType) {
                        switch($summaryType) {
                            case 'today':
                                $summaryItems[] = SummaryDefinition::createOneDaySummary(
                                    'today',
                                    new DateTime(date('Y-m-d')),
                                    $summaryAttributes,
                                    24,
                                    'HOUR');
                            break;
                            case 'yesterday':
                                $summaryItems[] = SummaryDefinition::createOneDaySummary(
                                    'yesterday',
                                    (new DateTime(date('Y-m-d')))->sub(new DateInterval('P1D')),
                                    $summaryAttributes,
                                    24,
                                    'HOUR');
                            case '7days':
                                $summaryItems[] = SummaryDefinition::createDateRangeSummary(
                                    '7days',
                                    (new DateTime(date('Y-m-d')))->sub(new DateInterval('P7D')),
                                    (new DateTime(date('Y-m-d'))),
                                    $summaryAttributes,
                                    'DAY');
                            break;
                        }
                    }

                    foreach ($summaryItems as $summaryItem) {
                        $predicateStation = new Predicate('m.station_id = :station' , [ ':station' => $station->id ]);

                        $predicateDateRange = $summaryItem->createDateRangePredicate();
                        // $predicateDateRange = new Predicate('date(m.published_at) = :published_at', [ ':published_at' => $summaryItem->dateRange->format('Y-m-d') ]);

                        foreach($summaryItem->attributes as $label) {
                            $field = StatsUtils::canonicalizeFieldName($label);

                            $conditionSql = StatsUtils::mergePredicateConditions([$predicateStation, $predicateDateRange]);

                            $stm = $conn->prepareAndExecute("SELECT MAX(m.$field) FROM measures m WHERE $conditionSql",
                                StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));
                            $max = doubleval($stm->fetchColumn(0));

                            $stm = $conn->prepareAndExecute("SELECT MIN(m.$field) FROM measures m WHERE $conditionSql",
                                StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));
                            $min = doubleval($stm->fetchColumn(0));

                            $stm = $conn->prepareAndExecute("SELECT AVG(m.$field) FROM measures m WHERE $conditionSql",
                                StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));
                            $avg = doubleval($stm->fetchColumn(0));

                            $stm = $conn->prepareAndExecute("SELECT m.$field FROM measures m WHERE $conditionSql ORDER BY m.published_at DESC LIMIT 1",
                                StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));
                            $now = doubleval($stm->fetchColumn(0));

                            $datePaddingSql = $summaryItem->generateDatePaddingTableSql();

                            $seriesSql = "SELECT {$summaryItem->groupByMethod}(m.$field), " . StatsUtils::generateDateRowGroupBy($summaryItem->unit) . " AS group_date FROM measures AS m";
                            $seriesSql .= " RIGHT JOIN $datePaddingSql ON (" . StatsUtils::generateDatePaddingTableJoinCondition($summaryItem->unit) . " AND $conditionSql)";
                            $seriesSql .= " GROUP BY " . StatsUtils::generateDateRowGroupBy($summaryItem->unit);
                            $seriesSql .= " ORDER BY date_rows.published_at ";

                            // StatsUtils::sqlDebug($conn, $seriesSql, StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));

                            
                            $stm = $conn->prepareAndExecute($seriesSql, StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));
                            $all = StatsUtils::fetchSeries($stm);

                            $summary = [
                                'label' => $label,
                                'field' => $field,
                                'range' => $summaryItem->getRangeInfo(),
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
                            $data['summary'][$summaryItem->identifier][] = $summary;
                        }
                    }
                }
            }


            return $this->toJson($data);
        } else {
            return $this->toJson([ 'error' => 'Station not found' ]);
        }
    }
}
