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

$dataSources = [];
if (count($argv) > 1) {
    array_shift($argv);

    foreach($argv as $arg) {
        if ($arg == "china") {
            $dataSources[] = new ChinaAqiStudyDataSource($agent, $logger);
        } else if ($arg == "japan") {
            $dataSources[] = new JapanSoramameDataSource($agent, $logger);
        } else if ($arg == "taiwan") {
            $dataSources[] = new TaiwanEPADataSource($agent, $logger);
        }
    }
} else {
    $dataSources = [
        new TaiwanEPADataSource($agent, $logger),
        new JapanSoramameDataSource($agent, $logger),
        new ChinaAqiStudyDataSource($agent, $logger),
    ];
}
foreach($dataSources as $dataSource) {
    // $dataSource->updateStationDetails();
}
foreach($dataSources as $dataSource) {
    $dataSource->updateMeasurements();
}
