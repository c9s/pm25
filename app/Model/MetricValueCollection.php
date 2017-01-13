<?php
namespace PM25\Model;
use PM25\Model\MetricValueCollectionBase;
class MetricValueCollection
    extends MetricValueCollectionBase
{

    public function __call($method, $args) 
    {
        if (in_array($method, MetricValueSchema::$valueTables)) {
            $collection = new self;
            $collection->setPreferredTable($method);
            return $collection;
        }
        throw new RuntimeException('Invalid value table.');
    }

}
