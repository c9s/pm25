<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace PM25\Model;

use LazyRecord\BaseModel;

class MeasureBase  extends BaseModel {

    const schema_proxy_class = 'PM25\\Model\\MeasureSchemaProxy';
    const collection_class = 'PM25\\Model\\MeasureCollection';
    const model_class = 'PM25\\Model\\Measure';
    const table = 'measures';


public static $column_names = array (
  0 => 'station_id',
  1 => 'pm10',
  2 => 'pm25',
  3 => 'no2',
  4 => 'fpmi',
  5 => 'so2',
  6 => 'co',
  7 => 'o3',
  8 => 'aqi',
  9 => 'wind_speed',
  10 => 'wind_direction',
  11 => 'published_at',
  12 => 'id',
);
public static $column_hash = array (
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
  'id' => 1,
);
public static $mixin_classes = array (
);

}

