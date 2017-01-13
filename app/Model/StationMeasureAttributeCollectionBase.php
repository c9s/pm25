<?php
namespace App\Model;
use LazyRecord\BaseCollection;
class StationMeasureAttributeCollectionBase
    extends BaseCollection
{
    const schema_proxy_class = 'App\\Model\\StationMeasureAttributeSchemaProxy';
    const model_class = 'App\\Model\\StationMeasureAttribute';
    const table = 'station_measure_attributes';
    const read_source_id = 'default';
    const write_source_id = 'default';
}
