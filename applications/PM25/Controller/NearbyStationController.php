<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\StationCollection;
use LazyRecord\ConnectionManager;

class NearbyStationController extends Controller
{
    public function indexAction($latitude, $longitude)
    {
        $limit = intval($this->request->param('limit') ?: 10);
        // print_r([ 'latitude' => $latitude, 'longitude' => $longitude ]);
        $conns = ConnectionManager::getInstance();
        $conn = $conns->get('default');
        $stmt = $conn->prepareAndExecute("
            SELECT s.id, s.country, s.city, s.name, s.country_en, s.city_en, s.name_en, s.latitude, s.longitude, m.pm25, m.pm10, m.aqi, m.psi,
            111.045 * DEGREES(
                   ACOS(COS(RADIANS(:lat))
                 * COS(RADIANS(latitude))
                 * COS(RADIANS(:lon) - RADIANS(longitude))
                 + SIN(RADIANS(:lat)) * SIN(RADIANS(latitude)))) AS distance_km 
                 FROM stations s
                 LEFT JOIN (SELECT pm25, pm10, aqi, psi, station_id FROM measures s ORDER BY published_at DESC LIMIT 1) m ON (m.station_id = s.id)
                 ORDER BY distance_km ASC LIMIT $limit
                 ", 
                 [ 
                     ':lat' => doubleval($latitude),
                     ':lon' => doubleval($longitude),
                     ':limit' => intval($limit),
                 ]);
        $rows = $stmt->fetchAll();
        foreach($rows as &$row) {
            $row['id'] = intval($row['id']);
            $row['latitude'] = doubleval($row['latitude']);
            $row['longitude'] = doubleval($row['longitude']);
            $row['pm25'] = floatval($row['pm25']);
            $row['pm10'] = floatval($row['pm10']);
            $row['aqi'] = floatval($row['aqi']);
            $row['psi'] = floatval($row['psi']);
            $row['distance_km'] = floatval($row['distance_km']);
        }
        return $this->toJson($rows);
    }
}
