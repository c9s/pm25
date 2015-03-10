<?php
require 'main.php';

use PM25\Model\Station;
use CLIFramework\Logger;
use LazyRecord\ConnectionManager;

$logger = Logger::getInstance();

$logger->info("Fetching opendata from opendata.epa.gov.tw ...");
$siteDetails = json_decode(file_get_contents('http://opendata.epa.gov.tw/ws/Data/AQXStation/?$orderby=StationName&$skip=0&$top=1000&format=json'), false);

foreach($siteDetails as $siteDetail) {
    $site = new Station;
    $site->load([ 'name' => $siteDetail->StationName ]);
    if ($site->id) {
        $logger->info("Station {$siteDetail->StationName} loaded");
        $site->update([ 
            'longitude' => doubleval($siteDetail->TWD97Lon),
            'latitude' => doubleval($siteDetail->TWD97Lat),
            'name_en' => $siteDetail->StationEngName,
            'address' => $siteDetail->StationAddress,
        ]);
    }

    if (! $site->address_en) {
        $result = $site->requestGeocode($siteDetail->StationAddress);
        // $result[0]->address_components;
        $englishAddress = $result->results[0]->formatted_address;
        echo "Updating english address => ", $englishAddress , "\n";
        $site->update(['address_en' => $englishAddress]);
    }

    if (! $site->city_en && $site->city) {
        $result = $site->requestGeocode($site->city . ', ' . $site->country);
        // $result[0]->address_components;
        $str = $result->results[0]->address_components[0]->long_name;
        echo "Updating english city name => ", $str , "\n";
        $site->update(['city_en' => $str]);
    }

}

// print_r($siteDetails);
