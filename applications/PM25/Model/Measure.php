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

        $data['pm25'] = doubleval($data['pm25']);
        $data['pm10'] = doubleval($data['pm10']);
        $data['so2'] = doubleval($data['so2']);
        $data['no2'] = doubleval($data['no2']);
        $data['o3'] = doubleval($data['o3']);

        $data['co'] = doubleval($data['co']);
        $data['fpmi'] = doubleval($data['fpmi']);
        $data['psi'] = doubleval($data['psi']);

        $data['wind_speed'] = doubleval($data['wind_speed']);
        $data['wind_direction'] = doubleval($data['wind_direction']);
        return $data;
    }


}

