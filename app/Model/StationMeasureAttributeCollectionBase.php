<?php
namespace App\Model;
use LazyRecord\BaseCollection;
class StationMeasureAttributeCollectionBase
    extends BaseCollection
{
    const schema_proxy_class = 'PM25\\Model\\StationMeasureAttributeSchemaProxy';
    const model_class = 'PM25\\Model\\StationMeasureAttribute';
    const table = 'station_measure_attributes';
    const read_source_id = 'default';
    const write_source_id = 'default';
}
