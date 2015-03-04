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
    const table = 'sites';


public static $column_names = array (
  0 => 'country',
  1 => 'name',
  2 => 'city',
  3 => 'id',
);
public static $column_hash = array (
  'country' => 1,
  'name' => 1,
  'city' => 1,
  'id' => 1,
);
public static $mixin_classes = array (
);

}

