<?php
/**
 * THIS FILE IS AUTO-GENERATED BY LAZYRECORD,
 * PLEASE DO NOT MODIFY THIS FILE DIRECTLY.
 * 
 * Last Modified: April 16th at 4:59pm
 */
namespace PM25\Model;


use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class MetricValueSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'station_id',
  1 => 'val',
  2 => 'unit_id',
  3 => 'published_at',
  4 => 'id',
);
    public static $column_hash = array (
  'station_id' => 1,
  'val' => 1,
  'unit_id' => 1,
  'published_at' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'station_id',
  1 => 'val',
  2 => 'unit_id',
  3 => 'published_at',
  4 => 'id',
);

    const schema_class = 'PM25\\Model\\MetricValueSchema';
    const collection_class = 'PM25\\Model\\MetricValueCollection';
    const model_class = 'PM25\\Model\\MetricValue';
    const model_name = 'MetricValue';
    const model_namespace = 'PM25\\Model';
    const primary_key = 'id';
    const table = 'so2';
    const label = 'MetricValue';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'station_id' => array( 
      'name' => 'station_id',
      'attributes' => array( 
          'isa' => 'int',
          'type' => 'mediumint',
          'primary' => NULL,
        ),
    ),
  'val' => array( 
      'name' => 'val',
      'attributes' => array( 
          'isa' => 'double',
          'type' => 'double',
          'primary' => NULL,
          'length' => 5,
          'decimals' => 3,
          'default' => 0,
        ),
    ),
  'unit_id' => array( 
      'name' => 'unit_id',
      'attributes' => array( 
          'isa' => 'int',
          'type' => 'smallint',
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
  'id' => array( 
      'name' => 'id',
      'attributes' => array( 
          'isa' => 'int',
          'type' => 'int',
          'primary' => true,
          'autoIncrement' => true,
        ),
    ),
);
        $this->columnNames     = array( 
  'id',
  'station_id',
  'val',
  'unit_id',
  'published_at',
);
        $this->primaryKey      = 'id';
        $this->table           = 'so2';
        $this->modelClass      = 'PM25\\Model\\MetricValue';
        $this->collectionClass = 'PM25\\Model\\MetricValueCollection';
        $this->label           = 'MetricValue';
        $this->relations       = array( 
  'station' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'self_schema' => 'PM25\\Model\\MetricValueSchema',
      'self_column' => 'station_id',
      'foreign_schema' => 'PM25\\Model\\StationSchema',
      'foreign_column' => 'id',
    ),
  'accessor' => 'station',
  'where' => NULL,
)),
  'unit' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'unit_id',
      'self_schema' => 'PM25\\Model\\MetricValueSchemaProxy',
      'foreign_column' => 'id',
      'foreign_schema' => 'PM25\\Model\\MetricUnitSchema',
    ),
  'accessor' => 'unit',
  'where' => NULL,
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
        _('MetricValue');
    }

}
