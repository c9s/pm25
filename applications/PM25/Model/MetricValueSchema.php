<?php
namespace PM25\Model;
use LazyRecord\Schema\SchemaDeclare;
use LazyRecord\Schema\TemplateSchema;

class MetricValueSchema extends TemplateSchema
{
    public function schema() 
    {
        $this->column('station_id')->mediumint()->notNull()->unsigned();

        // The default metric value column
        $this->column('val')->double(5,3)->default(0)->notNull();

        $this->column('unit_id')->smallint()->notNull()->unsigned();

        $this->column('published_at')->timestamp()->isa('DateTime')->notNull();

        $this->belongsTo('station', 'PM25\Model\StationSchema', 'id', 'station_id');

        $this->one('unit', 'PM25\Model\MetricUnitSchema', 'id', 'unit_id');
    }

    public function provideSchemas() {
        $schemas = [];
        foreach(['pm10', 'pm25', 'no2', 'co', 'o3', 'so2'] as $table) {
            $schema = new self;
            $schema->table($table);
            $schemas[] = $schema;
        }
        return $schemas;
    }
}
