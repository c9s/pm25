<?php
require 'main.php';
use PM25\Model\Station;
use PM25\Model\Measure;

$json = file_get_contents('http://opendata.epa.gov.tw/ws/Data/UVSite/?$orderby=PublishAgency&$skip=0&$top=1000&format=json');
$data = json_decode($json);
foreach($data as $item) {
    $station = new Station;
    $station->loadOrCreate([ 
        'country' => '台灣',
        'country_en' => 'Taiwan',
        'name' => $item->SiteName,
        'name_en' => $item->SiteEngName,
        'city' => $item->County,
        'area' => $item->TownShip,
        // 'city_en' => $item
        'address' => $item->SiteAddress,
        'longitude' => $item->TWD97Lon,
        'latitude'  => $item->TWD97Lat,
        'rawdata'   => yaml_emit($item, YAML_UTF8_ENCODING),
        'support_uv' => true,
    ], ['name','city']);
}


