<?php
namespace PM25;
use Phifty\Controller;
use PM25\Model\Station;
use PM25\Model\StationCollection;
use PM25\Model\MeasureCollection;
use PM25\Predicate;
use LazyRecord\ConnectionManager;
use LazyRecord\Connection;
use PDO;
use PDOStatement;
use LogicException;
use Exception;
use DateTime;
use DateInterval;

class StatsUtils {
    static public function generateDatePaddingTableSql($baseDate, $unit = 'HOUR', $period = 24, $as = 'date_rows') {
        // $unit = 'HOUR';
        // $period = 24;
        $fragments = [];
        for ($i = 0 ; $i < $period ; $i++ ) {
            $fragments[] = "SELECT DATE_ADD('$baseDate', INTERVAL $i $unit) AS published_at";
        }
        return '(' . join(' UNION ', $fragments) . ') AS ' . $as;
    }

    static public function canonicalizeFieldName($label)
    {
        $field = strtolower(preg_replace('/\W/', '', $label));
        if (strlen($field) == 0) {
            throw new LogicException("The label name $label can't be converted to field name");
        }
        return $field;
    }

    static public function mergePredicateConditions(array $predicates)
    {
        $fragments = [];
        foreach($predicates as $predicate) {
            $fragments[] = $predicate->condition;
        }
        return join(' AND ', $fragments);
    }

    static public function mergePredicateArguments(array $predicates) 
    {
        $args = [];
        foreach($predicates as $predicate) {
            $args = array_merge($args, $predicate->arguments);
        }
        return $args;
    }

    static public function fetchSeries(PDOStatement $stm, $column = 0, $typeCastFunc = 'doubleval')
    {
        return array_map($typeCastFunc, $stm->fetchAll(PDO::FETCH_COLUMN, $column));
    }
}
