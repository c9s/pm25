<?php
namespace PM25\Model;
use LazyRecord\BaseModel;
class MetricUnitBase
    extends BaseModel
{
    const schema_proxy_class = 'PM25\\Model\\MetricUnitSchemaProxy';
    const collection_class = 'PM25\\Model\\MetricUnitCollection';
    const model_class = 'PM25\\Model\\MetricUnit';
    const table = 'metric_units';
    const read_source_id = 'default';
    const write_source_id = 'default';
    const primary_key = 'id';
    public static $column_names = array (
      0 => 'identifier',
      1 => 'label',
      2 => 'form',
      3 => 'id',
    );
    public static $column_hash = array (
      'identifier' => 1,
      'label' => 1,
      'form' => 1,
      'id' => 1,
    );
    public static $mixin_classes = array (
    );
    public function getSchema()
    {
        if ($this->_schema) {
           return $this->_schema;
        }
        return $this->_schema = \LazyRecord\Schema\SchemaLoader::load('PM25\\Model\\MetricUnitSchemaProxy');
    }
    public function getIdentifier()
    {
        if (isset($this->_data['identifier'])) {
            return $this->_data['identifier'];
        }
    }
    public function getLabel()
    {
        if (isset($this->_data['label'])) {
            return $this->_data['label'];
        }
    }
    public function getForm()
    {
        if (isset($this->_data['form'])) {
            return $this->_data['form'];
        }
    }
    public function getId()
    {
        if (isset($this->_data['id'])) {
            return $this->_data['id'];
        }
    }
}
