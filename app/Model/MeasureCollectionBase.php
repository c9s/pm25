<?php
namespace App\Model;
use LazyRecord\BaseCollection;
class MeasureCollectionBase
    extends BaseCollection
{
    const schema_proxy_class = 'App\\Model\\MeasureSchemaProxy';
    const model_class = 'App\\Model\\Measure';
    const table = 'measures';
    const read_source_id = 'default';
    const write_source_id = 'default';
}
