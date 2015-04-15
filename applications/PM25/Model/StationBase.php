<?php
namespace PM25\Model;
use LazyRecord\BaseModel;
class StationBase
    extends BaseModel
{
    const schema_proxy_class = 'PM25\\Model\\StationSchemaProxy';
    const collection_class = 'PM25\\Model\\StationCollection';
    const model_class = 'PM25\\Model\\Station';
    const table = 'stations';
    const read_source_id = 'default';
    const write_source_id = 'default';
    const primary_key = NULL;
    public static $column_names = array (
      0 => 'id',
      1 => 'country',
      2 => 'country_en',
      3 => 'city',
      4 => 'city_en',
      5 => 'county',
      6 => 'county_en',
      7 => 'province',
      8 => 'province_en',
      9 => 'name',
      10 => 'name_en',
      11 => 'address',
      12 => 'address_en',
      13 => 'area',
      14 => 'area_en',
      15 => 'longitude',
      16 => 'latitude',
      17 => 'rawdata',
      18 => 'location',
      19 => 'support_uv',
      20 => 'support_air',
      21 => 'remark',
      22 => 'code',
      23 => 'data_source',
    );
    public static $column_hash = array (
      'id' => 1,
      'country' => 1,
      'country_en' => 1,
      'city' => 1,
      'city_en' => 1,
      'county' => 1,
      'county_en' => 1,
      'province' => 1,
      'province_en' => 1,
      'name' => 1,
      'name_en' => 1,
      'address' => 1,
      'address_en' => 1,
      'area' => 1,
      'area_en' => 1,
      'longitude' => 1,
      'latitude' => 1,
      'rawdata' => 1,
      'location' => 1,
      'support_uv' => 1,
      'support_air' => 1,
      'remark' => 1,
      'code' => 1,
      'data_source' => 1,
    );
    public static $mixin_classes = array (
    );
    public function getSchema()
    {
        if ($this->_schema) {
           return $this->_schema;
        }
        return $this->_schema = \LazyRecord\Schema\SchemaLoader::load('PM25\\Model\\StationSchemaProxy');
    }
    public function getId()
    {
        if (isset($this->_data['id'])) {
            return $this->_data['id'];
        }
    }
    public function getCountry()
    {
        if (isset($this->_data['country'])) {
            return $this->_data['country'];
        }
    }
    public function getCountryEn()
    {
        if (isset($this->_data['country_en'])) {
            return $this->_data['country_en'];
        }
    }
    public function getCity()
    {
        if (isset($this->_data['city'])) {
            return $this->_data['city'];
        }
    }
    public function getCityEn()
    {
        if (isset($this->_data['city_en'])) {
            return $this->_data['city_en'];
        }
    }
    public function getCounty()
    {
        if (isset($this->_data['county'])) {
            return $this->_data['county'];
        }
    }
    public function getCountyEn()
    {
        if (isset($this->_data['county_en'])) {
            return $this->_data['county_en'];
        }
    }
    public function getProvince()
    {
        if (isset($this->_data['province'])) {
            return $this->_data['province'];
        }
    }
    public function getProvinceEn()
    {
        if (isset($this->_data['province_en'])) {
            return $this->_data['province_en'];
        }
    }
    public function getName()
    {
        if (isset($this->_data['name'])) {
            return $this->_data['name'];
        }
    }
    public function getNameEn()
    {
        if (isset($this->_data['name_en'])) {
            return $this->_data['name_en'];
        }
    }
    public function getAddress()
    {
        if (isset($this->_data['address'])) {
            return $this->_data['address'];
        }
    }
    public function getAddressEn()
    {
        if (isset($this->_data['address_en'])) {
            return $this->_data['address_en'];
        }
    }
    public function getArea()
    {
        if (isset($this->_data['area'])) {
            return $this->_data['area'];
        }
    }
    public function getAreaEn()
    {
        if (isset($this->_data['area_en'])) {
            return $this->_data['area_en'];
        }
    }
    public function getLongitude()
    {
        if (isset($this->_data['longitude'])) {
            return $this->_data['longitude'];
        }
    }
    public function getLatitude()
    {
        if (isset($this->_data['latitude'])) {
            return $this->_data['latitude'];
        }
    }
    public function getRawdata()
    {
        if (isset($this->_data['rawdata'])) {
            return $this->_data['rawdata'];
        }
    }
    public function getLocation()
    {
        if (isset($this->_data['location'])) {
            return $this->_data['location'];
        }
    }
    public function getSupportUv()
    {
        if (isset($this->_data['support_uv'])) {
            return $this->_data['support_uv'];
        }
    }
    public function getSupportAir()
    {
        if (isset($this->_data['support_air'])) {
            return $this->_data['support_air'];
        }
    }
    public function getRemark()
    {
        if (isset($this->_data['remark'])) {
            return $this->_data['remark'];
        }
    }
    public function getCode()
    {
        if (isset($this->_data['code'])) {
            return $this->_data['code'];
        }
    }
    public function getDataSource()
    {
        if (isset($this->_data['data_source'])) {
            return $this->_data['data_source'];
        }
    }
}
