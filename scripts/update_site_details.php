<?php
require 'main.php';
use App\Model\Station;
use App\DataSource\Asia\TaiwanEPADataSource;
use App\DataSource\Asia\JapanSoramameDataSource;
use App\DataSource\Asia\ChinaAqiStudyDataSource;
use CLIFramework\Logger;
use LazyRecord\ConnectionManager;
use CurlKit\CurlAgent;
$logger = Logger::getInstance();
$agent = new CurlAgent;
$dataSources = [
    new TaiwanEPADataSource($agent, $logger),
    new JapanSoramameDataSource($agent, $logger),
    new ChinaAqiStudyDataSource($agent, $logger),
];
foreach($dataSources as $dataSource) {
    $dataSource->updateStationDetails();
}
