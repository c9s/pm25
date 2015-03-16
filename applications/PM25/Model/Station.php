<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace PM25\Model;
use PM25\Model\StationBase;

class Station  extends StationBase {
    const GOOGLE_GEOCODING_KEY = 'AIzaSyBq56dBXLlJOOfQP5UE2LVim1pXIYBEH5o';

    /*
        The returning structure:

        {
            "results" : [
                {
                    "address_components" : [
                        {
                        "long_name" : "Banqiao District",
                        "short_name" : "Banqiao District",
                        "types" : [ "administrative_area_level_3", "political" ]
                        },
                        {
                        "long_name" : "New Taipei City",
                        "short_name" : "New Taipei City",
                        "types" : [ "administrative_area_level_1", "political" ]
                        },
                        {
                        "long_name" : "Taiwan",
                        "short_name" : "TW",
                        "types" : [ "country", "political" ]
                        },
                        {
                        "long_name" : "220",
                        "short_name" : "220",
                        "types" : [ "postal_code" ]
                        }
                    ],
                    "formatted_address" : "Banqiao District, New Taipei City, Taiwan 220",
                    "geometry" : {
                        "bounds" : {
                        "northeast" : {
                            "lat" : 25.039807,
                            "lng" : 121.4887543
                        },
                        "southwest" : {
                            "lat" : 24.972071,
                            "lng" : 121.4244149
                        }
                        },
                        "location" : {
                        "lat" : 25.0114095,
                        "lng" : 121.4618415
                        },
                        "location_type" : "APPROXIMATE",
                        "viewport" : {
                        "northeast" : {
                            "lat" : 25.039807,
                            "lng" : 121.4887543
                        },
                        "southwest" : {
                            "lat" : 24.972071,
                            "lng" : 121.4244149
                        }
                        }
                    },
                    "place_id" : "ChIJG9DLhKgCaDQRWxhjDEDyk2w",
                    "types" : [ "administrative_area_level_3", "political" ]
                }
            ],
            "status" : "OK"
        }

     */
    public function updateLocation() {
        $obj = $this->requestGeocode($this->getAddress());
        if ($obj->status === "OK" 
            && $obj->results[0] 
            && $obj->results[0]->geometry 
            && $obj->results[0]->geometry->location
            && $this->id)
        {
            return $this->update([
                'longitude' => $obj->results[0]->geometry->location->lng,
                'latitude' => $obj->results[0]->geometry->location->lat,
            ]);
        }
    }

    public function requestGeocode($address) {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';
        $url .= '?' . http_build_query([ 
            'address' => $address,
            'key' => self::GOOGLE_GEOCODING_KEY,
        ]);
        return json_decode(file_get_contents($url));
    }

    public function getAddress() {
        if ($this->address) {
            return $this->address;
        }
        return join(', ', [$this->country, $this->city, $this->name]);
    }


    public function toArray()
    {
        $data = parent::toArray();
        $data['longitude'] = doubleval($data['longitude']);
        $data['latitude'] = doubleval($data['latitude']);
        $data['id'] = doubleval($data['id']);
        return $data;
    }

}

