<?php
require 'main.php';
use PM25\Model\SiteCollection;

$sites = new SiteCollection;
foreach($sites as $site) {
    echo "Updating ", $site->name, ": ";
    $site->updateLocation();
    printf("%f, %f\n", $site->longitude, $site->latitude);
}
