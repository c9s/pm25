<?php
namespace App\Model;
use SplEnum;

class MetricUnitEnum extends SplEnum {
    const __default = self::January;
    const PPM = 1;
    const PPMC = 2;
    const PPMV = 3;
    const PPB = 4;
    const PPBC = 5;
    const PPBV = 6;
    const UGM3 = 7;
    const μGM3 = 7;
    const MGM3 = 8;
    const CMSEC = 9; // cm/sec

    const MSEC = 10; // m/sec
    const MS = 10; // m/sec

    const KMSEC = 11; // km/sec

    const C = 12; // ℃

    static public function valueByLabel($label)
    {
        $n = str_replace(['/','.'],['',''], strtoupper($label));
        if (!$n) {
            var_dump( $label ); 
        }
        return constant('App\Model\MetricUnitEnum::' . $n);
    }

    static public function label($const) 
    {
        switch($const) {
        case self::PPMC:
            return 'ppmC';
            break;
        case self::PPMV:
            return 'ppmV';
            break;
        case self::PPM:
            return 'ppm';
            break;
        case self::C:
            return '℃';
            break;
        case self::PPMV:
            return 'ppmV';
            break;
        case self::PPMC:
            return 'ppmC';
            break;
        case self::PPB:
            return 'ppb';
            break;
        case self::PPBM:
            return 'ppbM';
            break;
        case self::PPBM:
            return 'ppbC';
            break;
        case self::UGM3:
            return 'μg/m3';
            break;
        case self::MSEC: 
        case self::MS:
            return 'm/sec';
            break;
        case self::KMSEC:
            return 'km/sec';
            break;
        case self::CMSEC:
            return 'cm/sec';
            break;
        }

    }
}

