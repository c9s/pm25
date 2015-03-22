<?php
require 'main.php';
use PM25\DataSource\Asia\JapanSoramameDataSource;
use CLIFramework\Logger;
use CurlKit\CurlAgent;

$agent = new CurlAgent;
$agent->setTimeout(10000); // 10 seconds
$agent->setConnectionTimeout(10000);

$logger = Logger::getInstance();
$dataSource = new JapanSoramameDataSource($agent, $logger);
// $stations = $dataSource->updateStationDetails([ 'start_from' => '神奈川県' ]);
$dataSource->updateStationDetails();
$dataSource->updateMeasurements();
