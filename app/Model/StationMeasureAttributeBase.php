<?php
namespace App\Model;
use LazyRecord\BaseModel;
class StationMeasureAttributeBase
    extends BaseModel
{
    const schema_proxy_class = 'App\\Model\\StationMeasureAttributeSchemaProxy';
    const collection_class = 'App\\Model\\StationMeasureAttributeCollection';
    const model_class = 'App\\Model\\StationMeasureAttribute';
    const table = 'station_measure_attributes';
    const read_source_id = 'default';
    const write_source_id = 'default';
    const primary_key = 'id';
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
    public function getSchema()
    {
        if ($this->_schema) {
           return $this->_schema;
        }
        return $this->_schema = \LazyRecord\Schema\SchemaLoader::load('App\\Model\\StationMeasureAttributeSchemaProxy');
    }
    public function getStationId()
    {
        if (isset($this->_data['station_id'])) {
            return $this->_data['station_id'];
        }
    }
    public function getAttributeId()
    {
        if (isset($this->_data['attribute_id'])) {
            return $this->_data['attribute_id'];
        }
    }
    public function getId()
    {
        if (isset($this->_data['id'])) {
            return $this->_data['id'];
        }
    }
}
