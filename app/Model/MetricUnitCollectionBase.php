<?php
namespace PM25\Model;
use LazyRecord\BaseCollection;
class MetricUnitCollectionBase
    extends BaseCollection
{
    const schema_proxy_class = 'PM25\\Model\\MetricUnitSchemaProxy';
    const model_class = 'PM25\\Model\\MetricUnit';
    const table = 'metric_units';
    const read_source_id = 'default';
    const write_source_id = 'default';
}
