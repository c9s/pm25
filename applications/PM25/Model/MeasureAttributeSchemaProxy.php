<?php
/**
 * THIS FILE IS AUTO-GENERATED BY LAZYRECORD,
 * PLEASE DO NOT MODIFY THIS FILE DIRECTLY.
 * 
 * Last Modified: April 10th at 1:00pm
 */
namespace PM25\Model;


use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class MeasureAttributeSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'label',
  1 => 'identifier',
  2 => 'unit',
  3 => 'id',
);
    public static $column_hash = array (
  'label' => 1,
  'identifier' => 1,
  'unit' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'label',
  1 => 'identifier',
  2 => 'unit',
  3 => 'id',
);

        const schema_class = 'PM25\\Model\\MeasureAttributeSchema';
        const collection_class = 'PM25\\Model\\MeasureAttributeCollection';
        const model_class = 'PM25\\Model\\MeasureAttribute';
        const model_name = 'MeasureAttribute';
        const model_namespace = 'PM25\\Model';
        const primary_key = 'id';
        const table = 'measure_attributes';
        const label = 'MeasureAttribute';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'label' => array( 
      'name' => 'label',
      'attributes' => array( 
          'type' => 'varchar(30)',
          'isa' => 'str',
          'size' => 30,
        ),
    ),
  'identifier' => array( 
      'name' => 'identifier',
      'attributes' => array( 
          'type' => 'varchar(30)',
          'isa' => 'str',
          'size' => 30,
        ),
    ),
  'unit' => array( 
      'name' => 'unit',
      'attributes' => array( 
          'type' => 'varchar(10)',
          'isa' => 'str',
          'size' => 10,
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
  'label',
  'identifier',
  'unit',
);
        $this->primaryKey      = 'id';
        $this->table           = 'measure_attributes';
        $this->modelClass      = 'PM25\\Model\\MeasureAttribute';
        $this->collectionClass = 'PM25\\Model\\MeasureAttributeCollection';
        $this->label           = 'MeasureAttribute';
        $this->relations       = array( 
  'station_measure_attributes' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'PM25\\Model\\MeasureAttributeSchema',
      'foreign_column' => 'attribute_id',
      'foreign_schema' => 'PM25\\Model\\StationMeasureAttributeSchema',
    ),
)),
  'stations' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'relation_junction' => 'station_measure_attributes',
      'relation_foreign' => 'station',
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
        _('MeasureAttribute');
    }

}
