<?php
require 'main.php';
use App\Model\Site;
use App\Model\Measure;

/*
 * 全国城市空气质量实时发布网
 * http://113.108.142.147:20035/emcpublish/
 * http://113.108.142.147:20035/emcpublish/
 * http://113.108.142.147:20031/arcgis/rest/services/CNEMC/ChinaMap20121228_/MapServer
 *
 * http://www.cnemc.cn/citystatus/airDailyReport.jsp?name=%CE%C2%D6%DD
 * http://www.cnemc.cn/citystatus/airMap.jsp
 *
 * 數據分享
 * http://www.cnemc.cn/publish/106/news/news_43353.html
 *
 *
 * aqistudy:
 *
 * curl -D city=上海 http://www.aqistudy.cn/api/getdata_citydetailinfo_memcache.php | json_pp
 * http://www.aqistudy.cn/
 * 
 */

/*
 * http://datacenter.mep.gov.cn/report/air_forecast/dairy_forecast.jsp
 * http://datacenter.mep.gov.cn/report/air_daily/air_dairy.jsp
 * http://datacenter.mep.gov.cn/report/air_daily/airMain.jsp
 * http://datacenter.mep.gov.cn/report/air_daily/comprehensive.jsp
 *
 * 中國環境監測總站
 * http://www.cnemc.cn/publish/totalWebSite/0492/newList_1.html
 *
 * PM25.in
 * http://pm25.in/api_doc
 * PM25.in News: http://www.moobuu.com/app/2035.jhtml
 * http://pm25.in/beijing
 * http://www.pm25s.com/guangzhou.html
 *
 *
 * 北京
 * https://twitter.com/BeijingAir
 * http://www.bjmemc.com.cn/g370.aspx
 * http://jc.bjmemc.com.cn/AirQualityDaily/DataSearch.aspx
 * https://github.com/iLeoDo/AirSpider
 *
 * 上海市環境監測中心
 * http://www.semc.com.cn/home/index.aspx
 * http://www.semc.gov.cn/aqi/home/Index.aspx
 * http://www.semc.gov.cn/aqi/home/DayData.aspx 每日
 * http://219.233.250.35:8086/
 * http://www.airnow.gov/index.cfm?action=aqibasics.aqi
 * https://twitter.com/CGShanghaiAir
 *
 * 美國大使館上海歷史監測資料
 * http://www.stateair.net/web/historical/1/4.html 
 *
 * RSS:
 * http://www.stateair.net/web/rss/1/1.xml
 *
 * http://218.94.78.75/airwebsite72jshb/
 * http://115.236.164.226:8099/aqi/flex/index.html
 *
 *
 * 北京即時空氣質量發布
 * http://zx.bjmemc.com.cn/web/index.aspx
 *
 * 中國環境保護部
 * http://english.mep.gov.cn/
 * http://datacenter.mep.gov.cn/report/air_daily/air_dairy_en.jsp
 *
 */

$url = 'http://aqicn.org/publishingdata/json/';
$opts = [
  'http'=> [
    'method' => "GET",
    'header' => "Accept-language: en\r\n" .
        "Content-Type: application/json\r\n" . 
        "User-Agent: Curl\r\n"
  ]
];
$context = stream_context_create($opts);
$json = file_get_contents($url, false, $context);
$obj = json_decode($json);
print_r( $obj ); 
