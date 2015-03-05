<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace PM25\Model;
use PM25\Model\SiteBase;

class Site  extends SiteBase {
    const GOOGLE_GEOCODING_KEY = 'AIzaSyBq56dBXLlJOOfQP5UE2LVim1pXIYBEH5o';


    public function updateLocation() {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';

        $url .= '?' . http_build_query([ 
            'address' => $this->city . $this->name,
            'key' => self::GOOGLE_GEOCODING_KEY,
        ]);
        $obj = json_decode(file_get_contents($url));
        if ($obj->status === "OK") {
            return $this->update([
                'longitude' => $obj->results[0]->geometry->location->lng,
                'latitude' => $obj->results[0]->geometry->location->lat,
            ]);
        }
    }
}

