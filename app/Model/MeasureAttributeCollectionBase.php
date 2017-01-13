<?php
namespace App\Model;
use LazyRecord\BaseCollection;
class MeasureAttributeCollectionBase
    extends BaseCollection
{
    const schema_proxy_class = 'App\\Model\\MeasureAttributeSchemaProxy';
    const model_class = 'App\\Model\\MeasureAttribute';
    const table = 'measure_attributes';
    const read_source_id = 'default';
    const write_source_id = 'default';
}
