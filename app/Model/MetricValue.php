<?php
namespace App\Model;
use App\Model\MetricValueBase;
use App\Model\MetricValueSchema;
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
