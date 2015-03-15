<?php
namespace PM25\DataSource;
use CLIFramework\Logger;
use PM25\DataSource\BaseDataSource;
use CurlKit\CurlAgent;

class BaseDataSource
{
    public $logger;

    public $agent;

    public function __construct(CurlAgent $agent, Logger $logger) {
        $this->agent = $agent;
        $this->logger = $logger;
    }

}



