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
        $stmt = $conn->prepareAndExecute('SELECT s.city, s.name, s.longitude, s.latitude, m.pm25, m.pm10, m.wind_speed, m.wind_direction, m.published_at FROM measures m INNER JOIN (SELECT site_id, MAX(published_at) AS latest_published_at FROM measures GROUP BY site_id) AS lm ON (m.site_id = lm.site_id AND m.published_at = lm.latest_published_at) LEFT JOIN sites s ON (s.id = m.site_id) ORDER BY m.published_at DESC');
        $rows = $stmt->fetchAll();
        foreach($rows as &$row){
            $row['pm25'] = floatval($row['pm25']);
            $row['pm10'] = floatval($row['pm10']);

            $row['longitude'] = floatval($row['longitude']);
            $row['latitude'] = floatval($row['latitude']);

            $row['wind_speed'] = floatval($row['wind_speed']);
            $row['wind_direction'] = floatval($row['wind_direction']);
        }
        return $this->toJson($rows);
    }
}
