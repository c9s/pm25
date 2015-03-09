<?php
require 'main.php';

use PM25\Model\Site;
use PM25\Model\SiteCollection;
use CLIFramework\Logger;
use LazyRecord\ConnectionManager;


$logger = Logger::getInstance();

$conns = ConnectionManager::getInstance();
$conn = $conns->get('default');
$stmt = $conn->prepareAndExecute("UPDATE sites SET country_en = 'Taiwan' WHERE country = :country ", [ ':country' => '台灣' ]);
$stmt = $conn->prepareAndExecute("UPDATE sites SET country_en = 'China' WHERE country = :country ", [ ':country' => '中國' ]);


$sites = new SiteCollection;
$sites->where()->is('city_en', 'NULL')->or()->is('name_en', 'NULL');

foreach($sites as $site) {
    echo $site->name, "\n";
    $requestAddress = $site->name . ', ' . $site->city . ', ' . $site->country;
    echo $requestAddress, "\n";
    // $result = $site->requestGeocode($site->name . ', ' . $site->city . ', ' . $site->country);
}
