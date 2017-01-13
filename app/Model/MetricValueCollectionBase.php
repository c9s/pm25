<?php
namespace App\Model;
use LazyRecord\BaseCollection;
class MetricValueCollectionBase
    extends BaseCollection
{
    const schema_proxy_class = 'App\\Model\\MetricValueSchemaProxy';
    const model_class = 'App\\Model\\MetricValue';
    const table = 'ws';
    const read_source_id = 'default';
    const write_source_id = 'default';
}
