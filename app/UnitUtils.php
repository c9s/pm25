<?php
namespace App;

class UnitUtils
{
    static public function convertPPBtoPPM($val) {
        return $val * 1000;
    }

    static public functino convertPPMtoPPB($val) {
        return doubleval($val) / 1000;
    }
}



