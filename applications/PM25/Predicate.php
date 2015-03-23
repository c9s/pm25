<?php
namespace PM25;

class Predicate {
    public $condition;
    public $arguments = array();

    public function __construct($condition, array $arguments = array()) {
        $this->condition = $condition;
        $this->arguments = $arguments;
    }
}
