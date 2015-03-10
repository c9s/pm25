<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace PM25\Model;

use LazyRecord\BaseModel;

class SiteBase  extends BaseModel {

    const schema_proxy_class = 'PM25\\Model\\SiteSchemaProxy';
    const collection_class = 'PM25\\Model\\SiteCollection';
    const model_class = 'PM25\\Model\\Site';
    const table = 'stations';


public static $column_names = array (
  0 => 'country',
  1 => 'country_en',
  2 => 'city',
  3 => 'city_en',
  4 => 'name',
  5 => 'name_en',
  6 => 'address',
  7 => 'address_en',
  8 => 'longitude',
  9 => 'latitude',
  10 => 'id',
);
public static $column_hash = array (
  'country' => 1,
  'country_en' => 1,
  'city' => 1,
  'city_en' => 1,
  'name' => 1,
  'name_en' => 1,
  'address' => 1,
  'address_en' => 1,
  'longitude' => 1,
  'latitude' => 1,
  'id' => 1,
);
public static $mixin_classes = array (
);

}

