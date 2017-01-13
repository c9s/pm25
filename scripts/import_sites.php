<?php
require 'main.php';
use App\Model\Station;
$sites = json_decode(file_get_contents('http://opendata.epa.gov.tw/ws/Data/AQX/?top=1000&format=json'));

$record = new Station;
foreach($sites as $site) {
    // echo $site->StationName, "\n";
    $record->loadOrCreate([ 
        'country' => 'Taiwan',
        'city' => $site->County,
        'name' => $site->StationName,
    ], [ 'name', 'city' ]);
    echo $record->id, ' => ', $record->name, "\n";
}
