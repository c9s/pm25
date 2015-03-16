<?php
namespace PM25\Exception;
use RuntimeException;

class IncorrectDataException extends RuntimeException
{
    public $url;

    public $data;

    public $html;

    public function __construct($message, $url, $data = array(), $html = NULL)
    {
        parent::__construct($message);
        $this->url = $url;
        $this->data = $data;
        $this->html = $html;
    }

    public function getData() {
        return $this->data;
    }

    public function getUrl() {
        return $this->url;
    }
}




