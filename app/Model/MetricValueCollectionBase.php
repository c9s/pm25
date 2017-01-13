<?php
namespace PM25\Model;
use LazyRecord\BaseCollection;
class MetricValueCollectionBase
    extends BaseCollection
{
    const schema_proxy_class = 'PM25\\Model\\MetricValueSchemaProxy';
    const model_class = 'PM25\\Model\\MetricValue';
    const table = 'ws';
    const read_source_id = 'default';
    const write_source_id = 'default';
}
