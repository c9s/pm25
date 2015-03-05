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

class SiteSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'country',
  1 => 'city',
  2 => 'name',
  3 => 'longitude',
  4 => 'latitude',
  5 => 'id',
);
    public static $column_hash = array (
  'country' => 1,
  'city' => 1,
  'name' => 1,
  'longitude' => 1,
  'latitude' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'country',
  1 => 'city',
  2 => 'name',
  3 => 'longitude',
  4 => 'latitude',
  5 => 'id',
);

        const schema_class = 'PM25\\Model\\SiteSchema';
        const collection_class = 'PM25\\Model\\SiteCollection';
        const model_class = 'PM25\\Model\\Site';
        const model_name = 'Site';
        const model_namespace = 'PM25\\Model';
        const primary_key = 'id';
        const table = 'sites';
        const label = 'Site';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'country' => array( 
      'name' => 'country',
      'attributes' => array( 
          'type' => 'varchar(30)',
          'isa' => 'str',
          'size' => 30,
        ),
    ),
  'city' => array( 
      'name' => 'city',
      'attributes' => array( 
          'type' => 'varchar(30)',
          'isa' => 'str',
          'size' => 30,
        ),
    ),
  'name' => array( 
      'name' => 'name',
      'attributes' => array( 
          'type' => 'varchar(30)',
          'isa' => 'str',
          'size' => 30,
        ),
    ),
  'longitude' => array( 
      'name' => 'longitude',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
        ),
    ),
  'latitude' => array( 
      'name' => 'latitude',
      'attributes' => array( 
          'type' => 'double',
          'isa' => 'double',
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
  'country',
  'city',
  'name',
  'longitude',
  'latitude',
);
        $this->primaryKey      = 'id';
        $this->table           = 'sites';
        $this->modelClass      = 'PM25\\Model\\Site';
        $this->collectionClass = 'PM25\\Model\\SiteCollection';
        $this->label           = 'Site';
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
        _('Site');
    }

}
