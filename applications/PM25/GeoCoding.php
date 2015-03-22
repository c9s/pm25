<?php
namespace PM25;

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




