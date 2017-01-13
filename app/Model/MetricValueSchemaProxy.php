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

class MetricValueSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'id',
  1 => 'station_id',
  2 => 'val',
  3 => 'unit',
  4 => 'published_at',
);
    public static $column_hash = array (
  'id' => 1,
  'station_id' => 1,
  'val' => 1,
  'unit' => 1,
  'published_at' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'id',
  1 => 'station_id',
  2 => 'val',
  3 => 'unit',
  4 => 'published_at',
);

    const schema_class = 'App\\Model\\MetricValueSchema';
    const collection_class = 'App\\Model\\MetricValueCollection';
    const model_class = 'App\\Model\\MetricValue';
    const model_name = 'MetricValue';
    const model_namespace = 'App\\Model';
    const primary_key = 'id';
    const table = 'ws';
    const label = 'MetricValue';

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
  'unit' => array( 
      'name' => 'unit',
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
);
        $this->columnNames     = array( 
  'id',
  'station_id',
  'val',
  'unit',
  'published_at',
);
        $this->primaryKey      = 'id';
        $this->table           = 'ws';
        $this->modelClass      = 'App\\Model\\MetricValue';
        $this->collectionClass = 'App\\Model\\MetricValueCollection';
        $this->label           = 'MetricValue';
        $this->relations       = array( 
  'station' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'self_schema' => 'App\\Model\\MetricValueSchema',
      'self_column' => 'station_id',
      'foreign_schema' => 'App\\Model\\StationSchema',
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
        _('MetricValue');
    }

}