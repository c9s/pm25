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
        $this->agent->userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2328.0 Safari/537.36';
        $this->logger = $logger;
    }

}



