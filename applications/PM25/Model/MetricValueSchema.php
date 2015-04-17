<?php
namespace PM25\Model;
use LazyRecord\Schema\SchemaDeclare;
use LazyRecord\Schema\TemplateSchema;
use PM25\Model\MetricUnitEnum;
use LogicException;

class MetricValueSchema extends TemplateSchema
{
    static $valueTables = [
        'pm10', 'pm25', 'no2', 'co', 'o3', 'so2', 'no', 'nox', 'ox', 'ch4', 'spm', 'thc', 'sp', 'nmhc', 
        'ws', // wind speed
    ];

    static $valueUnits = [
        'pm10' => MetricUnitEnum::UGM3,
        'pm25' => MetricUnitEnum::UGM3,

        'no2' => MetricUnitEnum::PPB,
        'o3'  => MetricUnitEnum::PPB,

        'co'  => MetricUnitEnum::PPM,
        'so2' => MetricUnitEnum::PPM,
    ];

    static public function canonicalizeTableName($table) {
        return str_replace(['/','.'],['',''], strtolower($table));
    }

    public function schema() 
    {
        $this->column('station_id')->mediumint()->notNull()->unsigned();

        // The default metric value column
        $this->column('val')->double(5,3)->default(0)->notNull();

        $this->column('unit')->smallint()->notNull()->unsigned();

        $this->column('published_at')->timestamp()->isa('DateTime')->notNull();

        $this->belongsTo('station', 'PM25\Model\StationSchema', 'id', 'station_id');

        // $this->one('unit', 'PM25\Model\MetricUnitSchema', 'id', 'unit_id');
    }

    static public function getTableUnit($table) {
        if (isset(self::$valueUnits[$table])) {
            return self::$valueUnits[$table];
        }
        throw new LogicException("value unit for table '$table' is undefined.");
    }

    public function provideSchemas() {
        $schemas = [];
        foreach(self::$valueTables as $table) {
            $schema = new self;
            $schema->table($table);
            $schemas[] = $schema;
        }
        return $schemas;
    }
}
