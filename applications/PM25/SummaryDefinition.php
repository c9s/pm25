<?php
namespace PM25;
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

class SummaryDefinition { 

    const DATE_RANGE_NO_DATE = 0;

    const DATE_RANGE_ONE_DAY = 1;

    const DATE_RANGE_DATE_RANGE = 2;

    public $label;

    public $identifier;

    public $groupByMethod = 'AVG'; // SUM() or MIN() or AVG()

    public $unit = 'HOUR'; // group by HOUR

    public $interval = 24;

    public $attributes = [
        'PM2.5' => 'pm25',
        'PM10' => 'pm10',
        'O3' => 'o3', 
        'NO2' => 'no2',
        'CO' => 'co', 
        'SO2' => 'so2',
    ];

    public $dateRange = self::DATE_RANGE_ONE_DAY; // single date range or double date range

    public function __construct($identifier, $label = NULL) {
        $this->identifier = $identifier;
        $this->label = $label;
    }

    public function getRangeInfo() {
        return [
            'date'     => $this->dateRange[0]->format(DateTime::ATOM),
            'interval' => $this->interval,
            'unit'     => $this->unit,
        ];
    }

    static public function createDateRangeSummary($identifier, $label, DateTime $from, DateTime $to, array $attributes = ['PM2.5', 'PM10', 'O3', 'NO2', 'CO', 'SO2'], $unit = 'DAY') {
        $summary = new self($identifier, $label);
        $summary->setDateRange([$from, $to], $unit);
        return $summary;
    }

    static public function createOneDaySummary($identifier, $label, DateTime $date, array $attributes = ['PM2.5', 'PM10', 'O3', 'NO2', 'CO', 'SO2'], $interval = 24, $unit = 'HOUR') {
        $summary = new self($identifier, $label);
        $summary->dateRange = [$date];
        $summary->interval = $interval;
        $summary->unit = $unit;
        $summary->attributes = $attributes;
        return $summary;
    }

    public function setDateRange($dateRange, $unit)
    {
        $this->dateRange = $dateRange;
        $this->unit = $unit;
        if (count($this->dateRange) == 1) {

        } else if (count($this->dateRange) == 2) {
            list($fromDate, $toDate) = $this->dateRange;
            $interval = $fromDate->diff($toDate);
            if ($unit == 'DAY') {
                $this->interval = $interval->days;
            } else {
                throw new LogicException("unsupport unit");
            }
        }
    }

    public function createDateRangePredicate() {
        if ($this->getDateRangeType() == self::DATE_RANGE_ONE_DAY) {
            return new Predicate(
                'date(m.published_at) = :published_at', [
                    ':published_at' => $this->dateRange[0]->format('Y-m-d'),
                ]);
        } else if ($this->getDateRangeType() == self::DATE_RANGE_DATE_RANGE) {
            return new Predicate(
                'm.published_at BETWEEN :from_date AND :to_date', [
                    ':from_date' => $this->dateRange[0]->format('Y-m-d'),
                    ':to_date' => $this->dateRange[1]->format('Y-m-d'),
                ]);
        } else {
            throw new LogicException("Unsupported date range type.");
        }
    }


    public function generateDatePaddingTableSql() {
        if ($this->getDateRangeType() == self::DATE_RANGE_ONE_DAY) {
            return StatsUtils::generateDatePaddingTableSql($this->dateRange[0]->format('Y-m-d'),
                $this->interval,
                $this->unit
            );
        } else if ($this->getDateRangeType() == self::DATE_RANGE_DATE_RANGE) {
            list($fromDate, $toDate) = $this->dateRange;
            return StatsUtils::generateDatePaddingTableSql($fromDate->format('Y-m-d'),
                $this->interval,
                $this->unit
            );
        } else {
            throw new LogicException("Unsupported date range type.");
        }
    }

    public function getDateRangeType()
    {
        if (!is_array($this->dateRange)) {
            throw new LogicException('Invalid date range type');
        }

        if (count($this->dateRange) == 0) {
            return self::DATE_RANGE_NO_DATE;
        } else if (count($this->dateRange) == 1) {
            return self::DATE_RANGE_ONE_DAY;
        } else if (count($this->dateRange) > 1) {
            return self::DATE_RANGE_DATE_RANGE;
        } else {
            throw new LogicException('Invalid date range type');
        }
    }
}

