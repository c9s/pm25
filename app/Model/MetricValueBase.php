<?php
namespace App\Model;
use LazyRecord\BaseModel;
class MetricValueBase
    extends BaseModel
{
    const schema_proxy_class = 'App\\Model\\MetricValueSchemaProxy';
    const collection_class = 'App\\Model\\MetricValueCollection';
    const model_class = 'App\\Model\\MetricValue';
    const table = 'ws';
    const read_source_id = 'default';
    const write_source_id = 'default';
    const primary_key = 'id';
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
    public function getSchema()
    {
        if ($this->_schema) {
           return $this->_schema;
        }
        return $this->_schema = \LazyRecord\Schema\SchemaLoader::load('App\\Model\\MetricValueSchemaProxy');
    }
    public function getId()
    {
        if (isset($this->_data['id'])) {
            return $this->_data['id'];
        }
    }
    public function getStationId()
    {
        if (isset($this->_data['station_id'])) {
            return $this->_data['station_id'];
        }
    }
    public function getVal()
    {
        if (isset($this->_data['val'])) {
            return $this->_data['val'];
        }
    }
    public function getUnit()
    {
        if (isset($this->_data['unit'])) {
            return $this->_data['unit'];
        }
    }
    public function getPublishedAt()
    {
        if (isset($this->_data['published_at'])) {
            return $this->_data['published_at'];
        }
    }
}
