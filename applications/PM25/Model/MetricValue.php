<?php
namespace PM25\Model;
use PM25\Model\MetricValueBase;
use PM25\Model\MetricValueSchema;
use Exception;
use RuntimeException;

class MetricValue
    extends MetricValueBase
{

    static public function createWithTable($table)
    {
        $model = new self;
        $model->setPreferredTable($table);
        return $model;
    }

    public function __call($method, $args) 
    {
        if (in_array($method, MetricValueSchema::$valueTables)) {
            $model = new self;
            $model->setPreferredTable($method);
            return $model;
        }
        throw new RuntimeException('Invalid value table.');
    }


}
