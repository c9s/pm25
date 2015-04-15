<?php
namespace PM25\Model;
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

        $this->belongsTo('attribute', 'PM25\Model\MeasureAttributeSchema', 'id', 'attribute_id');
        $this->belongsTo('station', 'PM25\Model\StationSchema', 'id', 'station_id');
    }
}
