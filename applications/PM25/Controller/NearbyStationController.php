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
        $conns = ConnectionManager::getInstance();
        $conn = $conns->get('default');
        $sql = "
            SELECT s.id, s.country, s.country_en, s.city, s.city_en, s.name, s.name_en, s.address, s.address_en, s.country, s.country_en, s.latitude, s.longitude,
                 DISTANCE(s.latitude, s.longitude, :lat, :lon) as distance_km
                 FROM stations s
                 WHERE latitude != 0 AND longitude != 0
                 ORDER BY distance_km ASC LIMIT $limit
                 ";
        $args = [ 
                     ':lat' => doubleval($latitude),
                     ':lon' => doubleval($longitude),
                 ];

        $stations = new StationCollection;
        $stations->loadQuery($sql, $args);

        $rows = [];
        foreach($stations as $station) {
            $station->measurements->order('published_at', 'desc')->limit(1);
            $measurements = $station->measurements;
            $item = $station->toArray();
            $item['latitude'] = doubleval($item['latitude']);
            $item['longitude'] = doubleval($item['longitude']);
            $item['distance_km'] = doubleval($item['distance_km']);
            $item = array_merge($item, $measurements->first()->toArray());
            $rows[] = $item;
        }
        return $this->toJson($rows);
    }
}
