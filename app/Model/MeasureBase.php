<?php
namespace PM25\Model;
use LazyRecord\BaseModel;
class MeasureBase
    extends BaseModel
{
    const schema_proxy_class = 'PM25\\Model\\MeasureSchemaProxy';
    const collection_class = 'PM25\\Model\\MeasureCollection';
    const model_class = 'PM25\\Model\\Measure';
    const table = 'measures';
    const read_source_id = 'default';
    const write_source_id = 'default';
    const primary_key = 'id';
    public static $column_names = array (
      0 => 'id',
      1 => 'station_id',
      2 => 'pm10',
      3 => 'pm25',
      4 => 'no2',
      5 => 'fpmi',
      6 => 'so2',
      7 => 'co',
      8 => 'o3',
      9 => 'aqi',
      10 => 'wind_speed',
      11 => 'wind_direction',
      12 => 'published_at',
    );
    public static $column_hash = array (
      'id' => 1,
      'station_id' => 1,
      'pm10' => 1,
      'pm25' => 1,
      'no2' => 1,
      'fpmi' => 1,
      'so2' => 1,
      'co' => 1,
      'o3' => 1,
      'aqi' => 1,
      'wind_speed' => 1,
      'wind_direction' => 1,
      'published_at' => 1,
    );
    public static $mixin_classes = array (
    );
    public function getSchema()
    {
        if ($this->_schema) {
           return $this->_schema;
        }
        return $this->_schema = \LazyRecord\Schema\SchemaLoader::load('PM25\\Model\\MeasureSchemaProxy');
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
    public function getPm10()
    {
        if (isset($this->_data['pm10'])) {
            return $this->_data['pm10'];
        }
    }
    public function getPm25()
    {
        if (isset($this->_data['pm25'])) {
            return $this->_data['pm25'];
        }
    }
    public function getNo2()
    {
        if (isset($this->_data['no2'])) {
            return $this->_data['no2'];
        }
    }
    public function getFpmi()
    {
        if (isset($this->_data['fpmi'])) {
            return $this->_data['fpmi'];
        }
    }
    public function getSo2()
    {
        if (isset($this->_data['so2'])) {
            return $this->_data['so2'];
        }
    }
    public function getCo()
    {
        if (isset($this->_data['co'])) {
            return $this->_data['co'];
        }
    }
    public function getO3()
    {
        if (isset($this->_data['o3'])) {
            return $this->_data['o3'];
        }
    }
    public function getAqi()
    {
        if (isset($this->_data['aqi'])) {
            return $this->_data['aqi'];
        }
    }
    public function getWindSpeed()
    {
        if (isset($this->_data['wind_speed'])) {
            return $this->_data['wind_speed'];
        }
    }
    public function getWindDirection()
    {
        if (isset($this->_data['wind_direction'])) {
            return $this->_data['wind_direction'];
        }
    }
    public function getPublishedAt()
    {
        if (isset($this->_data['published_at'])) {
            return $this->_data['published_at'];
        }
    }
}
