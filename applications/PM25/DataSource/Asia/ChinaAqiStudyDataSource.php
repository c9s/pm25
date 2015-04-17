<?php
namespace PM25\DataSource\Asia;
use Symfony\Component\DomCrawler\Crawler;
use CLIFramework\Logger;
use CurlKit\CurlAgent;
use PM25\DataSource\BaseDataSource;
use PM25\Exception\IncorrectDataException;
use PM25\Model\Station;
use PM25\Model\StationCollection;
use PM25\Model\Measure;
use PM25\Model\MeasureCollection;
use PM25\Model\MetricValue;
use DOMElement;
use DOMText;
use DateTime;
use DateTimeZone;

class ChinaAqiStudyDataSource extends BaseDataSource
{
    const BASE_URL = 'http://www.aqistudy.cn/api/getdata_citydetailinfo_memcache.php';

    public function getProvinceArray() 
    {
        $this->logger->info("Loading city data...");
        $provinces = [];
        $provinceObjects = json_decode(file_get_contents('data/china-city.json'));
        foreach($provinceObjects as $provinceString) {
            list($province, $provinceEn, $provinceCode) = explode('|', $provinceString);
            $provinceEn = ucfirst($provinceEn);

            $provinces[] = [
                'name' => $province,
                'name_en' => $provinceEn,
                'code' => $provinceCode,
            ];
        }
        return $provinces;
    }

    // curl 'http://www.aqistudy.cn/api/getdata_cityweather.php' -H 'Cookie: saeut=114.42.186.27.1425660305620215; safedog-flow-item=A7E60C889AD9BDA5ABA693AB201BCAAD; pgv_pvi=2278100324; pgv_info=ssi=s3792988556; CNZZDATA5808503=cnzz_eid%3D1010962282-1425660312-null%26ntime%3D1426994751' -H 'Origin: http://www.aqistudy.cn' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: en-US,en;q=0.8,pt;q=0.6,zh-TW;q=0.4' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2328.0 Safari/537.36' -H 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' -H 'Accept: application/json, text/javascript, */*; q=0.01' -H 'Referer: http://www.aqistudy.cn/html/city_detail4.html?v=1.5' -H 'X-Requested-With: XMLHttpRequest' -H 'Connection: keep-alive' --data 'city=%E5%8C%97%E4%BA%AC&type=HOUR&startTime=2015-03-21+08%3A00%3A00&endTime=2015-03-22+11%3A00%3A00' --compressed
    public function updateStationDetails() {
        $provinces = $this->getProvinceArray();
        foreach($provinces as $provinceInfo) {
            $response = $this->agent->post('http://www.aqistudy.cn/api/getdata_citydetailinfo_memcache.php', [ 'city' => $provinceInfo['name'] ]);
            $body = json_decode($response->decodeBody());
            foreach($body->rows as $row) {
                $station = new Station;
                $ret = $station->createOrUpdate([
                    'country' => '中國',
                    'country_en' => 'China',
                    'province' => $provinceInfo['name'],
                    'province_en' => $provinceInfo['name_en'],
                    'city' => $provinceInfo['name'],
                    'city_en' => $provinceInfo['name_en'],
                    'data_source' => 'ChinaAqiStudyDataSource',
                    'name' => $row->position_name,
                ], ['country_en', 'city', 'name']);
                if ($ret->error) {
                    $this->logger->error($ret->message);
                }
                $this->logger->info(sprintf('%s (% 2s) - %s', $station->name , $station->id , $ret->message));

                if ($station->id) {
                    if (!$station->latitude && !$station->longitude) {
                        $this->logger->info('Updating geolocation from address');
                        // Translate the address to latitude and longitude
                        $station->updateLocation();
                    }
                }
            }
        }
    }

    public function updateMeasurements() 
    {

        /*
                    'pm25'         => $row->pm2_5,
                    'aqi'          => $row->aqi,
                    'pm10'         => $row->pm10,
                    'no2'          => $row->no2,
                    'co'           => $row->co,
                    'so2'          => $row->so2,
                    'o3'           => $row->o3,
         */
        $pm25 = MetricValue::createWithTable('pm25');
        $pm10 = MetricValue::createWithTable('pm10');
        $co   = MetricValue::createWithTable('co');
        $no2  = MetricValue::createWithTable('no2');
        $so2  = MetricValue::createWithTable('so2');
        $o3   = MetricValue::createWithTable('o3');



        $provinces = $this->getProvinceArray();
        foreach($provinces as $provinceInfo) {
            $this->logger->info("Fetching measurements from {$provinceInfo['name']}");

            $response = $this->agent->post('http://www.aqistudy.cn/api/getdata_citydetailinfo_memcache.php', [ 'city' => $provinceInfo['name'] ]);
            $body = json_decode($response->body);
            foreach($body->rows as $row) {
                $station = new Station;
                $station->load([ 'country_en' => 'China', 'province' => $provinceInfo['name'], 'name' => $row->position_name ]);
                if (!$station->id) {
                    $this->logger->error('Station not found: ' . $row->position_name);
                    continue;
                }

                $measurements = new MeasureCollection;
                $measurements->where([
                    'station_id' => $station->id,
                ]);
                $measurements->orderBy('published_at', 'DESC');
                $measurements->limit(1);
                $lastMeasurement = $measurements->first();


                /*
                    (
                        [position_name] => 徐汇上师大
                        [aqi] => 31
                        [quality] => 优
                        [pm2_5] => 21
                        [pm10] => 31
                        [co] => 0.606
                        [no2] => 33
                        [o3] => 72
                        [o3_8h] => 77
                        [so2] => 11
                        [primary_pollutant] => —
                        [time_point] => 2015-03-07 20:00:00
                    )
                */
                $time = new DateTime($row->time_point);

                if ($lastMeasurement && $lastMeasurement->published_at && $time <= $lastMeasurement->published_at) {
                    $this->logger->info(sprintf("Skipping older measurements: %s", $time->format(DateTime::ATOM)));
                    continue;
                }

                $measure = new Measure;
                $ret = $measure->createOrUpdate([
                    'station_id'   => $station->id,
                    'pm25'         => $row->pm2_5,
                    'aqi'          => $row->aqi,
                    'pm10'         => $row->pm10,
                    'no2'          => $row->no2,
                    'co'           => $row->co,
                    'so2'          => $row->so2,
                    'o3'           => $row->o3,
                    'published_at' => $time->format(DateTime::ATOM),
                ], ['station_id', 'published_at']);
                if ($ret->error) {
                    $this->logger->error($ret->message);
                }
                $this->logger->info("Measure: " . $ret->message);
            }
        }
    }
}

