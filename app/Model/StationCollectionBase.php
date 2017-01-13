<?php
namespace App\Model;
use LazyRecord\BaseCollection;
class StationCollectionBase
    extends BaseCollection
{
    const schema_proxy_class = 'PM25\\Model\\StationSchemaProxy';
    const model_class = 'PM25\\Model\\Station';
    const table = 'stations';
    const read_source_id = 'default';
    const write_source_id = 'default';
}
