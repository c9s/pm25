<?php
/**
 * THIS FILE IS AUTO-GENERATED BY LAZYRECORD,
 * PLEASE DO NOT MODIFY THIS FILE DIRECTLY.
 * 
 * Last Modified: March 5th at 6:12pm
 */
namespace PM25\Model;


use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class MeasureSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'site_id',
  1 => 'pm10',
  2 => 'pm25',
  3 => 'no2',
  4 => 'fpmi',
  5 => 'so2',
  6 => 'c0',
  7 => 'psi',
  8 => 'status_text',
  9 => 'wind_speed',
  10 => 'wind_direction',
  11 => 'published_at',
  12 => 'id',
);
    public static $column_hash = array (
  'site_id' => 1,
  'pm10' => 1,
  'pm25' => 1,
  'no2' => 1,
  'fpmi' => 1,
  'so2' => 1,
  'c0' => 1,
  'psi' => 1,
  'status_text' => 1,
  'wind_speed' => 1,
  'wind_direction' => 1,
  'published_at' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'site_id',
  1 => 'pm10',
  2 => 'pm25',
  3 => 'no2',
  4 => 'fpmi',
  5 => 'so2',
  6 => 'c0',
  7 => 'psi',
  8 => 'status_text',
  9 => 'wind_speed',
  10 => 'wind_direction',
  11 => 'published_at',
  12 => 'id',
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
  'site_id' => array( 
      'name' => 'site_id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
        ),
    ),
  'pm10' => array( 
      'name' => 'pm10',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
          'default' => 0,
        ),
    ),
  'pm25' => array( 
      'name' => 'pm25',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
          'default' => 0,
        ),
    ),
  'no2' => array( 
      'name' => 'no2',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
          'default' => 0,
        ),
    ),
  'fpmi' => array( 
      'name' => 'fpmi',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
          'default' => 0,
        ),
    ),
  'so2' => array( 
      'name' => 'so2',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
          'default' => 0,
        ),
    ),
  'c0' => array( 
      'name' => 'c0',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
          'default' => 0,
        ),
    ),
  'psi' => array( 
      'name' => 'psi',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
          'default' => 0,
        ),
    ),
  'status_text' => array( 
      'name' => 'status_text',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
          'default' => 0,
        ),
    ),
  'wind_speed' => array( 
      'name' => 'wind_speed',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
        ),
    ),
  'wind_direction' => array( 
      'name' => 'wind_direction',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
        ),
    ),
  'published_at' => array( 
      'name' => 'published_at',
      'attributes' => array( 
          'type' => 'timestamp',
          'isa' => 'DateTime',
          'timezone' => true,
        ),
    ),
  'id' => array( 
      'name' => 'id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'primary' => true,
          'autoIncrement' => true,
        ),
    ),
);
        $this->columnNames     = array( 
  'id',
  'site_id',
  'pm10',
  'pm25',
  'no2',
  'fpmi',
  'so2',
  'c0',
  'psi',
  'status_text',
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
  'site' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'PM25\\Model\\MeasureSchema',
      'self_column' => 'site_id',
      'foreign_schema' => 'PM25\\Model\\SiteSchema',
      'foreign_column' => 'id',
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
