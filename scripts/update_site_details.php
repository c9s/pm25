<?php
require 'main.php';
use PM25\Model\Station;
use PM25\DataSource\Asia\TaiwanEPADataSource;
use PM25\DataSource\Asia\JapanSoramameDataSource;
use CLIFramework\Logger;
use LazyRecord\ConnectionManager;
use CurlKit\CurlAgent;
$logger = Logger::getInstance();
$agent = new CurlAgent;
$dataSources = [
    new TaiwanEPADataSource($agent, $logger),
    new JapanSoramameDataSource($agent, $logger),
];
foreach($dataSources as $dataSource) {
    $dataSource->updateStationDetails();
}
