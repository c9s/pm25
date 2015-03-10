<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace PM25\Model;

use PM25\Model\MeasureBase;

class Measure  extends MeasureBase {


    public function toArray()
    {
        $data = parent::toArray();
        $data['id'] = intval($data['id']);

        $data['pm25'] = floatval($data['pm25']);
        $data['pm10'] = floatval($data['pm10']);
        $data['so2'] = floatval($data['so2']);
        $data['no2'] = floatval($data['no2']);

        $data['c0'] = floatval($data['c0']);
        // $data['fpmi'] = floatval($data['fpmi']);

        $data['wind_speed'] = floatval($data['wind_speed']);
        $data['wind_direction'] = floatval($data['wind_direction']);
        return $data;
    }


}

