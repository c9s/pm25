<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace PM25\Model;
use PM25\Model\StationBase;
use PM25\Model\MeasureAttribute;
use PM25\Model\StationMeasureAttribute;
use PM25\GeoCoding;
use LazyRecord\ConnectionManager;
use Exception;

class RequestFailException extends Exception { 

    public $url;
    public $params = array();
    public $response;

    public function __construct($message, $url, $params, $response) {
        $this->url = $url;
        $this->params = $params;
        $this->response = $response;
        parent::__construct($message);
    }
}

class Station  extends StationBase {
    // Kayo Google Map
    // const GOOGLE_GEOCODING_KEY = 'AIzaSyBq56dBXLlJOOfQP5UE2LVim1pXIYBEH5o';

    // FindCafe
    const GOOGLE_GEOCODING_KEY = 'AIzaSyDUzJ4PkxJkLvcDc_UxZBDEzFEdZHQ8cWI';

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
        if ($result = GeoCoding::request($this->getAddress())) {
            if ($obj->results[0] 
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
    }

    public function requestGeocode($address) {
        $args = array(
            'address' => $address,
            'key' => self::GOOGLE_GEOCODING_KEY,
        );
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';
        $url .= '?' . http_build_query($args);
        $response = file_get_contents($url);
        if ($response === false) {
            throw new RequestFailException('Google Map API request failed.', $url, $args, $response);
        }
        return json_decode($response);
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

    public function removeAttribute($identifier) {
        $attribute = new MeasureAttribute;
        $attribute->load([ 'identifier' => $identifier ]);

        $junction = new StationMeasureAttribute;
        $junction->load([ 'station_id' => $this->id, 'attribute_id' => $attribute->id ]);
        if ($junction->id) {
            return $junction->delete();
        }
        return false;
    }

    public function addAttribute($identifier, $label = NULL) {
        $attribute = new MeasureAttribute;
        $attribute->load([ 'identifier' => $identifier ]);

        $junction = new StationMeasureAttribute;
        return $junction->loadOrCreate([ 'station_id' => $this->id, 'attribute_id' => $attribute->id ]);
    }

    public function getAttributeArray()
    {
        $attributes = $this->measure_attributes;
        $array = array();
        foreach($attributes as $attribute) {
            $array[ $attribute->identifier ] = TRUE;
        }
        return $array;
    }

    public function importAttributes(array $attributes)
    {
        if (empty($attributes)) {
            throw new RuntimeException('Empty attributes');
        }

        foreach($attributes as $key => $val) {
            $identifier = trim(strtolower($key));
            if ($val) {
                $attribute = new MeasureAttribute;
                $attribute->createOrUpdate([ 'identifier' => $identifier, 'label' => $key ], ['identifier']);
                if (!$attribute->id) {
                    throw new Exception('Attribute id is undefined');
                }
                $junction = new StationMeasureAttribute;
                $junction->loadOrCreate([ 'attribute_id' => $attribute->id, 'station_id' => $this->id ]);
            } else {
                $attribute = new MeasureAttribute;
                $attribute->load([ 'identifier' => $identifier ]);
                if ($attribute->id) {
                    $junction = new StationMeasureAttribute;
                    $junction->load([ 'attribute_id' => $attribute->id, 'station_id' => $this->id ]);
                    if ($junction->id) {
                        $junction->delete();
                    }
                }
            }
        }
    }


}

