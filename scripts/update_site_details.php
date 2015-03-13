<?php
require 'main.php';
use PM25\Model\Station;
use PM25\DataSource\TaiwanEPADataSource;
use CLIFramework\Logger;
use LazyRecord\ConnectionManager;
$logger = Logger::getInstance();
$dataSource = new TaiwanEPADataSource;
$dataSource->updateStationDetails();
