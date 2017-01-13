<?php
namespace App;

class Utils
{
    static public function measurement_description(array $data) {
        $out = [];
        foreach ($data as $key => $val) {
            if (!in_array($key, [ 'published_at', 'station_id' ])) {
                $out[] = sprintf("%s:%.3f", $key, $val);
            }
        }
        return join(', ', $out);
    }

}


