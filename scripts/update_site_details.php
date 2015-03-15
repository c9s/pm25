<?php
require 'main.php';
use PM25\Model\Station;
use PM25\DataSource\Asia\TaiwanEPADataSource;
use PM25\DataSource\Asia\JapanEPADataSource;
use CLIFramework\Logger;
use LazyRecord\ConnectionManager;
$logger = Logger::getInstance();

$dataSources = [
    new TaiwanEPADataSource,
    new JapanEPADataSource,
];
foreach($dataSources as $dataSource) {
    $dataSource->updateStationDetails();
}
