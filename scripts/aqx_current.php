<?php
require 'main.php';
use App\Model\Station;
use App\Model\Measure;

$measures = json_decode(file_get_contents('http://opendata.epa.gov.tw/ws/Data/AQX/?top=1000&format=json'), true);
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

