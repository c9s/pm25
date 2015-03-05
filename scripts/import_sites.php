<?php
require 'main.php';
use PM25\Model\Site;
$sites = json_decode(file_get_contents('http://opendata.epa.gov.tw/ws/Data/AQX/?top=1000&format=json'));

$record = new Site;
foreach($sites as $site) {
    // echo $site->SiteName, "\n";
    $record->loadOrCreate([ 
        'country' => 'Taiwan',
        'city' => $site->County,
        'name' => $site->SiteName,
    ], [ 'name', 'city' ]);
    echo $record->id, ' => ', $record->name, "\n";
}
