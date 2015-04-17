<?php
namespace PM25\Model;
use LazyRecord\BaseModel;
class MetricValueBase
    extends BaseModel
{
    const schema_proxy_class = 'PM25\\Model\\MetricValueSchemaProxy';
    const collection_class = 'PM25\\Model\\MetricValueCollection';
    const model_class = 'PM25\\Model\\MetricValue';
    const table = 'so2';
    const read_source_id = 'default';
    const write_source_id = 'default';
    const primary_key = 'id';
    public static $column_names = array (
      0 => 'station_id',
      1 => 'val',
      2 => 'unit',
      3 => 'published_at',
      4 => 'id',
    );
    public static $column_hash = array (
      'station_id' => 1,
      'val' => 1,
      'unit' => 1,
      'published_at' => 1,
      'id' => 1,
    );
    public static $mixin_classes = array (
    );
    public function getSchema()
    {
        if ($this->_schema) {
           return $this->_schema;
        }
        return $this->_schema = \LazyRecord\Schema\SchemaLoader::load('PM25\\Model\\MetricValueSchemaProxy');
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
    public function getId()
    {
        if (isset($this->_data['id'])) {
            return $this->_data['id'];
        }
    }
}
