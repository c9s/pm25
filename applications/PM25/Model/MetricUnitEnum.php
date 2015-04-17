<?php
namespace PM25\Model;
use SplEnum;

class MetricUnitEnum extends SplEnum {
    const __default = self::January;
    const PPM = 1;
    const PPB = 2;
    const UGM3 = 3;
    const MSEC = 4;

    static public function label($const) 
    {
        switch($const) {
        case self::PPM:
            return 'ppm';
            break;
        case self::PPB:
            return 'ppb';
            break;
        case self::UGM3:
            return 'ug/m3';
            break;
        case self::MSEC:
            return 'm/sec';
            break;
        }

    }
}

