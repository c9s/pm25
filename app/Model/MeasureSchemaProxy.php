<?php
/**
 * THIS FILE IS AUTO-GENERATED BY LAZYRECORD,
 * PLEASE DO NOT MODIFY THIS FILE DIRECTLY.
 * 
 * Last Modified: April 17th at 10:03pm
 */
namespace App\Model;


use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class MeasureSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'id',
  1 => 'station_id',
  2 => 'pm10',
  3 => 'pm25',
  4 => 'no2',
  5 => 'fpmi',
  6 => 'so2',
  7 => 'co',
  8 => 'o3',
  9 => 'aqi',
  10 => 'wind_speed',
  11 => 'wind_direction',
  12 => 'published_at',
);
    public static $column_hash = array (
  'id' => 1,
  'station_id' => 1,
  'pm10' => 1,
  'pm25' => 1,
  'no2' => 1,
  'fpmi' => 1,
  'so2' => 1,
  'co' => 1,
  'o3' => 1,
  'aqi' => 1,
  'wind_speed' => 1,
  'wind_direction' => 1,
  'published_at' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'id',
  1 => 'station_id',
  2 => 'pm10',
  3 => 'pm25',
  4 => 'no2',
  5 => 'fpmi',
  6 => 'so2',
  7 => 'co',
  8 => 'o3',
  9 => 'aqi',
  10 => 'wind_speed',
  11 => 'wind_direction',
  12 => 'published_at',
);

    const schema_class = 'PM25\\Model\\MeasureSchema';
    const collection_class = 'PM25\\Model\\MeasureCollection';
    const model_class = 'PM25\\Model\\Measure';
    const model_name = 'Measure';
    const model_namespace = 'PM25\\Model';
    const primary_key = 'id';
    const table = 'measures';
    const label = 'Measure';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'id' => array( 
      'name' => 'id',
      'attributes' => array( 
          'isa' => 'int',
          'type' => 'bigint',
          'primary' => true,
          'autoIncrement' => true,
        ),
    ),
  'station_id' => array( 
      'name' => 'station_id',
      'attributes' => array( 
          'isa' => 'int',
          'type' => 'mediumint',
          'primary' => NULL,
        ),
    ),
  'pm10' => array( 
      'name' => 'pm10',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
          'length' => 5,
          'decimals' => 2,
          'default' => 0,
        ),
    ),
  'pm25' => array( 
      'name' => 'pm25',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
          'length' => 5,
          'decimals' => 2,
          'default' => 0,
        ),
    ),
  'no2' => array( 
      'name' => 'no2',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
          'default' => 0,
        ),
    ),
  'fpmi' => array( 
      'name' => 'fpmi',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
          'default' => 0,
        ),
    ),
  'so2' => array( 
      'name' => 'so2',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
          'default' => 0,
        ),
    ),
  'co' => array( 
      'name' => 'co',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
          'default' => 0,
        ),
    ),
  'o3' => array( 
      'name' => 'o3',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
          'default' => 0,
        ),
    ),
  'aqi' => array( 
      'name' => 'aqi',
      'attributes' => array( 
          'isa' => 'int',
          'type' => 'smallint',
          'primary' => NULL,
        ),
    ),
  'wind_speed' => array( 
      'name' => 'wind_speed',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
        ),
    ),
  'wind_direction' => array( 
      'name' => 'wind_direction',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
        ),
    ),
  'published_at' => array( 
      'name' => 'published_at',
      'attributes' => array( 
          'isa' => 'DateTime',
          'type' => 'timestamp',
          'primary' => NULL,
          'timezone' => true,
        ),
    ),
);
        $this->columnNames     = array( 
  'id',
  'station_id',
  'pm10',
  'pm25',
  'no2',
  'fpmi',
  'so2',
  'co',
  'o3',
  'aqi',
  'wind_speed',
  'wind_direction',
  'published_at',
);
        $this->primaryKey      = 'id';
        $this->table           = 'measures';
        $this->modelClass      = 'PM25\\Model\\Measure';
        $this->collectionClass = 'PM25\\Model\\MeasureCollection';
        $this->label           = 'Measure';
        $this->relations       = array( 
  'station' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'self_schema' => 'PM25\\Model\\MeasureSchema',
      'self_column' => 'station_id',
      'foreign_schema' => 'PM25\\Model\\StationSchema',
      'foreign_column' => 'id',
    ),
  'accessor' => 'station',
  'where' => NULL,
  'orderBy' => array( 
    ),
)),
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }


    /**
     * Code block for message id parser.
     */
    private function __() {
        _('Measure');
    }

}
