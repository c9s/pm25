<?php
/**
 * THIS FILE IS AUTO-GENERATED BY LAZYRECORD,
 * PLEASE DO NOT MODIFY THIS FILE DIRECTLY.
 * 
 * Last Modified: April 17th at 10:03pm
 */
namespace PM25\Model;


use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class MetricUnitSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'id',
  1 => 'identifier',
  2 => 'label',
  3 => 'form',
);
    public static $column_hash = array (
  'id' => 1,
  'identifier' => 1,
  'label' => 1,
  'form' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'id',
  1 => 'identifier',
  2 => 'label',
  3 => 'form',
);

    const schema_class = 'PM25\\Model\\MetricUnitSchema';
    const collection_class = 'PM25\\Model\\MetricUnitCollection';
    const model_class = 'PM25\\Model\\MetricUnit';
    const model_name = 'MetricUnit';
    const model_namespace = 'PM25\\Model';
    const primary_key = 'id';
    const table = 'metric_units';
    const label = 'MetricUnit';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'id' => array( 
      'name' => 'id',
      'attributes' => array( 
          'isa' => 'int',
          'type' => 'smallint',
          'primary' => true,
          'autoIncrement' => true,
        ),
    ),
  'identifier' => array( 
      'name' => 'identifier',
      'attributes' => array( 
          'isa' => 'str',
          'type' => 'varchar',
          'primary' => NULL,
          'length' => 30,
        ),
    ),
  'label' => array( 
      'name' => 'label',
      'attributes' => array( 
          'isa' => 'str',
          'type' => 'varchar',
          'primary' => NULL,
          'length' => 30,
        ),
    ),
  'form' => array( 
      'name' => 'form',
      'attributes' => array( 
          'isa' => 'str',
          'type' => 'varchar',
          'primary' => NULL,
          'length' => 30,
        ),
    ),
);
        $this->columnNames     = array( 
  'id',
  'identifier',
  'label',
  'form',
);
        $this->primaryKey      = 'id';
        $this->table           = 'metric_units';
        $this->modelClass      = 'PM25\\Model\\MetricUnit';
        $this->collectionClass = 'PM25\\Model\\MetricUnitCollection';
        $this->label           = 'MetricUnit';
        $this->relations       = array( 
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }


    /**
     * Code block for message id parser.
     */
    private function __() {
        _('MetricUnit');
    }

}
