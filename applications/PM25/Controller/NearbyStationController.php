<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\StationCollection;
use LazyRecord\ConnectionManager;

class NearbyStationController extends Controller
{
    public function indexAction($latitude, $longitude)
    {
        $limit = intval($this->request->param('limit') ?: 5);
        // print_r([ 'latitude' => $latitude, 'longitude' => $longitude ]);
        $conns = ConnectionManager::getInstance();
        $conn = $conns->get('default');

        // select DISTANCE(s.latitude, s.longitude, 35.702069, 121.775327) from stations s
        $stmt = $conn->prepareAndExecute("
            SELECT s.id, s.country, s.country_en, s.city, s.city_en, s.name, s.name_en, s.address, s.address_en, s.country, s.country_en, s.latitude, s.longitude,
                 DISTANCE(s.latitude, s.longitude, :lat, :lon) as distance_km
                 FROM stations s
                 WHERE latitude != 0 AND longitude != 0
                 ORDER BY distance_km ASC LIMIT $limit
                 ", 
                 [ 
                     ':lat' => doubleval($latitude),
                     ':lon' => doubleval($longitude),
                 ]);
        $rows = $stmt->fetchAll();
        foreach($rows as &$row) {
            $row['id'] = intval($row['id']);
            $row['latitude'] = doubleval($row['latitude']);
            $row['longitude'] = doubleval($row['longitude']);
            $row['distance_km'] = doubleval($row['distance_km']);
        }
        return $this->toJson($rows);
    }
}
