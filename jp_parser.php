<?php
require 'main.php';
use PM25\DataSource\Asia\JapanSoramameDataSource;
use PM25\Model\Station;
use CLIFramework\Logger;
use CurlKit\CurlAgent;

$agent = new CurlAgent;
$agent->setTimeout(10000); // 10 seconds
$agent->setConnectionTimeout(10000);

$logger = Logger::getInstance();
$dataSource = new JapanSoramameDataSource($agent, $logger);
$dataSource->updateMeasurements();

/*
$station = new Station(176);
$lastMeasurement = $station->measurements->first();
print_r($lastMeasurement->published_at);
*/

/*
// $stations = $dataSource->updateStationDetails([ 'start_from' => '神奈川県' ]);
$dataSource->updateStationDetails();
 */
