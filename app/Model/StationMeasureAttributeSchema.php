<?php
namespace App\Model;
use LazyRecord\Schema\SchemaDeclare;

class StationMeasureAttributeSchema extends SchemaDeclare
{
    public function schema() {
        $this->column('station_id')
            ->int()
            ->notNull()
            ;

        $this->column('attribute_id')
            ->int()
            ->notNull()
            ;

        $this->belongsTo('attribute', 'App\Model\MeasureAttributeSchema', 'id', 'attribute_id');
        $this->belongsTo('station', 'App\Model\StationSchema', 'id', 'station_id');
    }
}
