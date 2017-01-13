<?php
namespace App\Model;
use LazyRecord\BaseCollection;
class MetricUnitCollectionBase
    extends BaseCollection
{
    const schema_proxy_class = 'App\\Model\\MetricUnitSchemaProxy';
    const model_class = 'App\\Model\\MetricUnit';
    const table = 'metric_units';
    const read_source_id = 'default';
    const write_source_id = 'default';
}
