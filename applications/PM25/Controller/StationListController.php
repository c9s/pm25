<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\StationCollection;
use LazyRecord\ConnectionManager;

class StationListController extends Controller
{
    public function indexAction() {
        $limit = $this->request->param('limit');

        $cacheKey = "pm25-station-list-$limit";
        if ($json = apc_fetch($cacheKey)) {
            header('Content-Type: application/json');
            return $json;
        }

        $conns = ConnectionManager::getInstance();
        $conn = $conns->get('default');
        $sql = "SELECT id, country, country_en, city, city_en, name, name_en, address, address_en, latitude, longitude 
            FROM stations s 
            WHERE country_en = 'Taiwan' OR country_en = 'China'
            ORDER BY country ASC, city ASC, name ASC, id DESC";
        if ($limit) {
            $sql .= ' LIMIT ' . intval($limit);
        }

        $stmt = $conn->prepareAndExecute($sql);
        $rows = $stmt->fetchAll();
        foreach($rows as &$row) {
            $row['id'] = intval($row['id']);
            $row['longitude'] = doubleval($row['longitude']);
            $row['latitude'] = doubleval($row['latitude']);
        }
        $json = $this->toJson($rows);
        apc_store($cacheKey, $json, 60 * 60 * 24);
        return $json;
    }
}
