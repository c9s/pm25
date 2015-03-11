<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\MeasureCollection;
use LazyRecord\ConnectionManager;


class CurrentController extends Controller
{
    public function indexAction() {
        $conns = ConnectionManager::getInstance();
        $conn = $conns->get('default');
        $stmt = $conn->prepareAndExecute('SELECT s.id, s.country, s.country_en, s.city, s.city_en, s.name, s.name_en, s.address, s.address_en, s.longitude, s.latitude, m.pm25, m.pm10, m.wind_speed, m.wind_direction, m.published_at FROM measures m INNER JOIN (SELECT station_id, MAX(published_at) AS latest_published_at FROM measures GROUP BY station_id) AS lm ON (m.station_id = lm.station_id AND m.published_at = lm.latest_published_at) LEFT JOIN stations s ON (s.id = m.station_id) ORDER BY m.published_at DESC');
        $rows = $stmt->fetchAll();
        foreach($rows as &$row){
            $row['id'] = intval($row['id']);

            $row['pm25'] = floatval($row['pm25']);
            $row['pm10'] = floatval($row['pm10']);
            $row['so2'] = floatval($row['so2']);
            $row['no2'] = floatval($row['no2']);
            $row['fpmi'] = floatval($row['fpmi']);

            $row['longitude'] = floatval($row['longitude']);
            $row['latitude'] = floatval($row['latitude']);

            $row['wind_speed'] = floatval($row['wind_speed']);
            $row['wind_direction'] = floatval($row['wind_direction']);
        }
        return $this->toJson($rows);
    }
}
