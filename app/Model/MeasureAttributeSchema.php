<?php
namespace App\Model;
use LazyRecord\Schema\SchemaDeclare;

class MeasureAttributeSchema extends SchemaDeclare
{
    public function schema() {
        $this->column('label')
            ->varchar(30)
            ;

        $this->column('identifier')
            ->varchar(30)
            ;

        $this->column('unit')
            ->varchar(10)
            ;

        $this->many('station_measure_attributes', 'App\Model\StationMeasureAttributeSchema', 'attribute_id', 'id');
        $this->manyToMany('stations', 'station_measure_attributes', 'station');
    }
}
