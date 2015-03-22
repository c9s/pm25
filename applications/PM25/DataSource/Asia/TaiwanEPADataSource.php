<?php
namespace PM25\DataSource\Asia;
use PM25\Model\Station;
use PM25\Model\Measure;
use PM25\Exception\IncorrectDataException;
use DateTime;
use Exception;
use CLIFramework\Logger;
use LazyRecord\ConnectionManager;
use PM25\DataSource\BaseDataSource;
use CurlKit\CurlAgent;

interface DataSourceInterface {

    public function updateStationDetails();

}

class TaiwanEPADataSource extends BaseDataSource implements DataSourceInterface
{

    const STATION_DETAILS_URL = 'http://opendata.epa.gov.tw/ws/Data/AQXSite/?$orderby=SiteName&$skip=0&$top=1000&format=json';

    public function fetchStationDetails() {
        return json_decode(file_get_contents(self::STATION_DETAILS_URL), false);
    }

    public function updateStationDetails() {
        $details = $this->fetchStationDetails();
        foreach($details as $siteDetail) {
            echo "Checking " , $siteDetail->SiteName, "\n";
            $station = new Station;
            $ret = $station->createOrUpdate([ 
                'longitude' => doubleval($siteDetail->TWD97Lon),
                'latitude' => doubleval($siteDetail->TWD97Lat),
                'code'    => $siteDetail->SiteEngName,
                'name_en' => $siteDetail->SiteEngName,
                'address' => $siteDetail->SiteAddress,
                'area'    => $siteDetail->Township,
                'rawdata' => yaml_emit($siteDetail, YAML_UTF8_ENCODING),
                // 'remark'  => [ 'type' => $siteDetail->SiteType ],
            ], [ 'country_en' => 'Taiwan', 'code' => $siteDetail->SiteEngName ]);
            if ($ret->error) {
                $this->logger->error($ret->message);
            }

            // If we don't have address_en, we should translate the address to english
            if (! $station->address_en) {
                $result = $station->requestGeocode($siteDetail->SiteAddress);
                if ($result->status === "OK") {
                    // $result[0]->address_components;
                    $englishAddress = $result->results[0]->formatted_address;
                    $this->logger->info("Updating english address => $englishAddress");
                    $station->update(['address_en' => $englishAddress]);
                } else {
                    $this->logger->error('Geocoding API response: ' . $result->status);
                }
            }

            if (! $station->city_en && $station->city) {
                $result = $station->requestGeocode($station->city . ', ' . $station->country);
                if ($result->status === "OK") {
                    // $result[0]->address_components;
                    $str = $result->results[0]->address_components[0]->long_name;
                    $this->logger->info("Updating english city name => $str");
                    $station->update(['city_en' => $str]);
                } else {
                    $this->logger->error('Geocoding API response: ' . $result->status);
                }
            }
        }
    }

    public function updateMeasurements()
    {
        $response = $this->agent->get('http://opendata.epa.gov.tw/ws/Data/AQX/?top=1000&format=json');
        $measures = json_decode($response->body, true);
        $record = new Measure;
        foreach($measures as $measure) {
            $time = new DateTime($measure['PublishTime']);

            $site = new Station;
            $site->load(['name' => $measure['SiteName']]);
            $ret = $record->loadOrCreate([
                // status: "普通",
                'station_id'        => $site->id,
                'psi'            => floatval($measure['PSI']),
                'so2'            => floatval($measure['SO2']),
                'co'             => floatval($measure['CO']),
                'o3'             => floatval($measure['O3']),
                'pm10'           => floatval($measure['PM10']),
                'pm25'           => floatval($measure['PM2.5']),
                'no2'             => floatval($measure['NO2']),
                'fpmi'            => floatval($measure['FPMI']),
                'wind_speed'      => floatval($measure['WindSpeed']),
                'wind_direction'  => floatval($measure['WindDirec']),
                'published_at'    => $time->format(DateTime::ATOM),
                'major_pollutant' => $measure['MajorPollutant'],
            ], ['station_id', 'published_at']);

            if (!$ret->success) {
                die("import error\n");
            }
            print_r($record->toArray());
            echo $measure['PublishTime'] , " => ", $time->format(DateTime::ATOM), " => " , $time->getTimestamp(), "\n";
            // echo $site->StationName, "\n";
        }
    }
}




