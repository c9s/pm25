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
        $enableSummary = $this->request->param('summary');

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
            if ($enableSummary) {
                if ($conn = $this->getDefaultConnection()) {

                    // Use attributes to generate the summary fields
                    // $attributes = $station->measure_attributes;
                    // print_r($attributes->toArray());

                    $summaryLabels = ['PM2.5', 'PM10', 'O3', 'NO2', 'CO', 'SO2'];
                    $summaryDates = [ 
                        'today' => date('Y-m-d'),
                        'yesterday' => (new DateTime)->sub(new DateInterval('P1D'))->format('Y-m-d'),
                    ];


                    foreach($summaryDates as $dateLabel => $dateString) {
                        $predicateStation = new Predicate('station_id = :station' , [ ':station' => $station->id ]);
                        $predicateDateRange = new Predicate('date(m.published_at) = :published_at', [ ':published_at' => $dateString ]);

                        foreach($summaryLabels as $label) {
                            $field = StatsUtils::canonicalizeFieldName($label);

                            $conditionSql = StatsUtils::mergePredicateConditions([$predicateStation, $predicateDateRange]);

                            $stm = $conn->prepareAndExecute("SELECT MAX($field) FROM measures m WHERE $conditionSql",
                                StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));
                            $max = doubleval($stm->fetchColumn(0));

                            $stm = $conn->prepareAndExecute("SELECT MIN($field) FROM measures m WHERE $conditionSql",
                                StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));
                            $min = doubleval($stm->fetchColumn(0));

                            $stm = $conn->prepareAndExecute("SELECT $field FROM measures m WHERE $conditionSql ORDER BY m.published_at DESC LIMIT 1",
                                StatsUtils::mergePredicateArguments([$predicateStation, $predicateDateRange]));
                            $now = doubleval($stm->fetchColumn(0));


                            $unit = 'HOUR';
                            $period = 24;
                            $datePaddingSql = StatsUtils::generateDatePaddingTableSql($dateString, $unit, $period);

                            $seriesSql = "SELECT IF(m.$field, m.$field, 0) FROM measures AS m";
                            $seriesSql .= " RIGHT JOIN $datePaddingSql ON (" . StatsUtils::generateDatePaddingTableJoinCondition($unit) . " AND $conditionSql)";
                            $seriesSql .= " ORDER BY date_rows.published_at";
                            $stm = $conn->prepareAndExecute($seriesSql, [
                                ':station' => $station->id,
                                ':published_at' => $dateString,
                            ]);

                            $all = StatsUtils::fetchSeries($stm);

                            $summary = [
                                'label' => $label,
                                'field' => $field,
                                'period' => $period, // period
                                'unit'   => $unit,
                                'date1' => $dateString,
                                'chart' => 'area',
                                'max' => $max,
                                'min' => $min,
                                'now' => $now,
                                'series' => $all,
                            ];
                            $data['summary'][$dateLabel][] = $summary;
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
