<?php
require 'main.php';

use PM25\Model\Site;
use CLIFramework\Logger;

$siteDetails = json_decode(file_get_contents('http://opendata.epa.gov.tw/ws/Data/AQXSite/?$orderby=SiteName&$skip=0&$top=1000&format=json'), false);

$logger = Logger::getInstance();

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

    $result = $site->requestGeocode($siteDetail->SiteAddress);
    // $result[0]->address_components;
    $englishAddress = $result->results[0]->formatted_address;
    echo " => ", $englishAddress , "\n";
    $site->update(['address_en' => $englishAddress]);
}

// print_r($siteDetails);
