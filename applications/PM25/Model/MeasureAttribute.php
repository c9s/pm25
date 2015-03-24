<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace PM25\Model;

use PM25\Model\MeasureAttributeBase;

class MeasureAttribute  extends MeasureAttributeBase {

    public function beforeUpdate($args) {
        if (isset($args['identifier'])) {
            $args['identifier'] = strtolower($args['identifier']);
        }
        return $args;
    }

    public function beforeCreate($args) {
        if (isset($args['identifier'])) {
            $args['identifier'] = strtolower($args['identifier']);
        }
        return $args;
    }

}

