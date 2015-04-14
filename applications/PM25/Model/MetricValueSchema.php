<?php
namespace PM25\Model;
use LazyRecord\Schema\SchemaDeclare;
use LazyRecord\Schema\TemplateSchema;

abstract class MetricValueSchema extends TemplateSchema
{
    public function schema() 
    {
        $this->column('station_id')->mediumint()->notNull();

        // The default metric value column
        $this->column('val')->double(5,3)->default(0)->notNull();

        $this->column('unit_id')->int()->notNull();

        $this->column('published_at')->timestamp()->isa('DateTime')->notNull();

        $this->belongsTo('station', 'PM25\Model\StationSchema', 'id', 'station_id');

        $this->hasOne('unit', 'PM25\Model\MetricUnitSchema', 'id', 'unit_id');
    }

    public function provideSchemas() {
        $schemas = array();

        $schema = new self;
        $schema->table('co2');
        $schemas[] = $schema;

        return $schemas;
    }
}
