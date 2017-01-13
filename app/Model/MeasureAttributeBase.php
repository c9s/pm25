<?php
namespace App\Model;
use LazyRecord\BaseModel;
class MeasureAttributeBase
    extends BaseModel
{
    const schema_proxy_class = 'PM25\\Model\\MeasureAttributeSchemaProxy';
    const collection_class = 'PM25\\Model\\MeasureAttributeCollection';
    const model_class = 'PM25\\Model\\MeasureAttribute';
    const table = 'measure_attributes';
    const read_source_id = 'default';
    const write_source_id = 'default';
    const primary_key = 'id';
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
    public function getSchema()
    {
        if ($this->_schema) {
           return $this->_schema;
        }
        return $this->_schema = \LazyRecord\Schema\SchemaLoader::load('PM25\\Model\\MeasureAttributeSchemaProxy');
    }
    public function getLabel()
    {
        if (isset($this->_data['label'])) {
            return $this->_data['label'];
        }
    }
    public function getIdentifier()
    {
        if (isset($this->_data['identifier'])) {
            return $this->_data['identifier'];
        }
    }
    public function getUnit()
    {
        if (isset($this->_data['unit'])) {
            return $this->_data['unit'];
        }
    }
    public function getId()
    {
        if (isset($this->_data['id'])) {
            return $this->_data['id'];
        }
    }
}
