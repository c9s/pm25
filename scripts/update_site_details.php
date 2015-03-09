<?php
require 'main.php';

use PM25\Model\Site;
use CLIFramework\Logger;
use LazyRecord\ConnectionManager;

$logger = Logger::getInstance();

$logger->info("Fetching opendata from opendata.epa.gov.tw ...");
$siteDetails = json_decode(file_get_contents('http://opendata.epa.gov.tw/ws/Data/AQXSite/?$orderby=SiteName&$skip=0&$top=1000&format=json'), false);

foreach($siteDetails as $siteDetail) {
    $site = new Site;
    $site->load([ 'name' => $siteDetail->SiteName ]);
    if ($site->id) {
        $logger->info("Site {$siteDetail->SiteName} loaded");
        $site->update([ 
            'longitude' => doubleval($siteDetail->TWD97Lon),
            'latitude' => doubleval($siteDetail->TWD97Lat),
            'name_en' => $siteDetail->SiteEngName,
            'address' => $siteDetail->SiteAddress,
        ]);
    }

    if (! $site->address_en) {
        $result = $site->requestGeocode($siteDetail->SiteAddress);
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