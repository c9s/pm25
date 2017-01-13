#!/usr/bin/env php
<?php
require 'main.php';
use App\Model\Station;
use App\Model\Measure;
use CLIFramework\Logger;

$logger = Logger::getInstance();

// China
$url = 'http://www.aqistudy.cn/api/getdata_citydetailinfo_memcache.php';

$agent = new CurlKit\CurlAgent;
$cities = array('上海', '北京', '重庆', '深圳', '广州', '青岛', '成都', '苏州', '西安', '山東');

foreach($cities as $cityName) {
    $response = $agent->post('http://www.aqistudy.cn/api/getdata_citydetailinfo_memcache.php', [ 'city' => $cityName ]);
    $body = json_decode($response->decodeBody());
    foreach($body->rows as $row) {
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
        $site = new Station;
        $site->loadOrCreate([
            'country' => '中國',
            'city' => $cityName,
            'name' => $row->position_name,
        ], ['city', 'name']);


        $logger->info("Updating site " . $site->name . "(" . $site->id . ")");

        $time = new DateTime($row->time_point);

        $measure = new Measure;
        $ret = $measure->loadOrCreate([
            'site_id'      => $site->id,
            'pm25'         => $row->pm2_5,
            'aqi'          => $row->aqi,
            'pm10'         => $row->pm10,
            'no2'          => $row->no2,
            'co'           => $row->co,
            'so2'          => $row->so2,
            'published_at' => $time->format(DateTime::ATOM),
            // 'o3' => $row->o3,
        ], ['site_id', 'published_at']);
        if ($ret->error) {
            print_r($ret);
        }
    }
}

