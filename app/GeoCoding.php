<?php
namespace App;
use Exception;

class GeocodingErrorResultException extends Exception {

    public $status;

    public $response;

    public $messages = array(
        "OK" => "indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.",
        "ZERO_RESULTS" => "indicates that the geocode was successful but returned no results. This may occur if the geocoder was passed a non-existent address.",
        "OVER_QUERY_LIMIT" => "indicates that you are over your quota.",
        "REQUEST_DENIED" => "indicates that your request was denied.",
        "INVALID_REQUEST" => "generally indicates that the query (address, components or latlng) is missing.",
        "UNKNOWN_ERROR" => "indicates that the request could not be processed due to a server error. The request may succeed if you try again.",
    );

    public function __construct($response) {
        $this->response = $response;
        $this->status = $response;
        if (isset($this->messages[$this->status])) {
            $message = $this->messages[$this->status];
            parent::__construct($message, $this->status);
        } else {
            parent::__construct("undefined status: {$this->status}");
        }
    }
}

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

class GeoCoding
{
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


    public static function request($address) {
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
        $result = json_decode($response);

        if ($result->status == "ZERO_RESULTS") {
            return NULL;
        }
        if ($result->status != "OK") {
            throw GeocodingErrorResultException($result);
        }
        return $result;
    }
}




