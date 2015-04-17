<?php
namespace PM25;

class UnitUtils
{
    static public function convertPPBtoPPM($val) {
        return $val * 1000;
    }

    static public functino convertPPMtoPPB($val) {
        return doubleval($val) / 1000;
    }
}



