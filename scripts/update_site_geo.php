<?php
require 'main.php';
use PM25\Model\StationCollection;

$sites = new StationCollection;
$sites->where()
    ->is('address', 'NULL');
foreach($sites as $site) {
    if (!$site->longitude || !$site->latitude) {
        echo "Updating ", $site->name, ": " . $site->getAddress() . " => ";
        $site->updateLocation();
        printf("%f, %f\n", $site->longitude, $site->latitude);
    }

}
