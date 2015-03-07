<?php
require 'main.php';
use PM25\Model\SiteCollection;

$sites = new SiteCollection;
foreach($sites as $site) {
    if (!$site->longitude || !$site->latitude) {
        echo "Updating ", $site->name, ": " . $site->getAddress() . " => ";
        $site->updateLocation();
        printf("%f, %f\n", $site->longitude, $site->latitude);
    }

}
