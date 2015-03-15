<?php
namespace PM25\DataSource\Asia;
use PM25\Model\Station;
use PM25\DataSource\TaiwanEPADataSource;
use PM25\Exception\IncorrectDataException;
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
                'name_en' => $siteDetail->SiteEngName,
                'address' => $siteDetail->SiteAddress,
                'area'    => $siteDetail->Township,
                'rawdata' => yaml_emit($siteDetail),
                // 'remark'  => [ 'type' => $siteDetail->SiteType ],
            ], [ 'name' => $siteDetail->SiteName ]);
            if ($ret->error) {
                die($ret->message);
            }

            // If we don't have address_en, we should translate the address to english
            if (! $station->address_en) {
                $result = $station->requestGeocode($siteDetail->SiteAddress);
                // $result[0]->address_components;
                $englishAddress = $result->results[0]->formatted_address;
                echo "Updating english address => ", $englishAddress , "\n";
                $site->update(['address_en' => $englishAddress]);
            }

            if (! $station->city_en && $station->city) {
                $result = $station->requestGeocode($station->city . ', ' . $station->country);
                // $result[0]->address_components;
                $str = $result->results[0]->address_components[0]->long_name;
                echo "Updating english city name => ", $str , "\n";
                $station->update(['city_en' => $str]);
            }
        }
    }
}




