<?php
namespace App;

class Predicate {
    public $condition;
    public $arguments = array();

    public function __construct($condition, array $arguments = array()) {
        $this->condition = $condition;
        $this->arguments = $arguments;
    }


    static public function mergeConditions(array $predicates)
    {
        $fragments = [];
        foreach($predicates as $predicate) {
            $fragments[] = $predicate->condition;
        }
        return join(' AND ', $fragments);
    }

    static public function mergeArguments(array $predicates) 
    {
        $args = [];
        foreach($predicates as $predicate) {
            $args = array_merge($args, $predicate->arguments);
        }
        return $args;
    }
}
