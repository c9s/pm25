<?php
require 'main.php';
use PM25\DataSource\Asia\JapanSoramameDataSource;
use PM25\DataSource\Asia\ChinaAqiStudyDataSource;
use CLIFramework\Logger;
use CurlKit\CurlAgent;

$agent = new CurlAgent;
$agent->setTimeout(10000); // 10 seconds
$agent->setConnectionTimeout(10000);

$logger = Logger::getInstance();
$dataSource = new ChinaAqiStudyDataSource($agent, $logger);
$dataSource->updateStationDetails();
// $dataSource->updateMeasurements();
