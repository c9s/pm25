<?php
/**
 * THIS FILE IS AUTO-GENERATED BY LAZYRECORD,
 * PLEASE DO NOT MODIFY THIS FILE DIRECTLY.
 * 
 * Last Modified: April 17th at 1:50pm
 */
namespace PM25\Model;


use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class StationMeasureAttributeSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'station_id',
  1 => 'attribute_id',
  2 => 'id',
);
    public static $column_hash = array (
  'station_id' => 1,
  'attribute_id' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'station_id',
  1 => 'attribute_id',
  2 => 'id',
);

    const schema_class = 'PM25\\Model\\StationMeasureAttributeSchema';
    const collection_class = 'PM25\\Model\\StationMeasureAttributeCollection';
    const model_class = 'PM25\\Model\\StationMeasureAttribute';
    const model_name = 'StationMeasureAttribute';
    const model_namespace = 'PM25\\Model';
    const primary_key = 'id';
    const table = 'station_measure_attributes';
    const label = 'StationMeasureAttribute';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'station_id' => array( 
      'name' => 'station_id',
      'attributes' => array( 
          'isa' => 'int',
          'type' => 'int',
          'primary' => NULL,
        ),
    ),
  'attribute_id' => array( 
      'name' => 'attribute_id',
      'attributes' => array( 
          'isa' => 'int',
          'type' => 'int',
          'primary' => NULL,
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
  'attribute_id',
);
        $this->primaryKey      = 'id';
        $this->table           = 'station_measure_attributes';
        $this->modelClass      = 'PM25\\Model\\StationMeasureAttribute';
        $this->collectionClass = 'PM25\\Model\\StationMeasureAttributeCollection';
        $this->label           = 'StationMeasureAttribute';
        $this->relations       = array( 
  'attribute' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'self_schema' => 'PM25\\Model\\StationMeasureAttributeSchema',
      'self_column' => 'attribute_id',
      'foreign_schema' => 'PM25\\Model\\MeasureAttributeSchema',
      'foreign_column' => 'id',
    ),
  'accessor' => 'attribute',
  'where' => NULL,
)),
  'station' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'self_schema' => 'PM25\\Model\\StationMeasureAttributeSchema',
      'self_column' => 'station_id',
      'foreign_schema' => 'PM25\\Model\\StationSchema',
      'foreign_column' => 'id',
    ),
  'accessor' => 'station',
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
        _('StationMeasureAttribute');
    }

}
