<?php
namespace PM25\DataSource;
use CLIFramework\Logger;
use PM25\DataSource\BaseDataSource;

class BaseDataSource
{
    public $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

}



