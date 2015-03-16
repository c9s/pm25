<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace PM25\Model;

use LazyRecord\BaseModel;

class StationBase  extends BaseModel {

    const schema_proxy_class = 'PM25\\Model\\StationSchemaProxy';
    const collection_class = 'PM25\\Model\\StationCollection';
    const model_class = 'PM25\\Model\\Station';
    const table = 'stations';


public static $column_names = array (
  0 => 'country',
  1 => 'country_en',
  2 => 'city',
  3 => 'city_en',
  4 => 'county',
  5 => 'county_en',
  6 => 'name',
  7 => 'name_en',
  8 => 'address',
  9 => 'address_en',
  10 => 'area',
  11 => 'area_en',
  12 => 'longitude',
  13 => 'latitude',
  14 => 'rawdata',
  15 => 'location',
  16 => 'support_uv',
  17 => 'support_air',
  18 => 'remark',
  19 => 'data_source',
  20 => 'id',
);
public static $column_hash = array (
  'country' => 1,
  'country_en' => 1,
  'city' => 1,
  'city_en' => 1,
  'county' => 1,
  'county_en' => 1,
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
  'data_source' => 1,
  'id' => 1,
);
public static $mixin_classes = array (
);

}

