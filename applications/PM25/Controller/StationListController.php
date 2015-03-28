<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\StationCollection;
use PM25\Predicate;
use LazyRecord\ConnectionManager;

class StationListController extends Controller
{
    public function indexAction() {
        $country = $this->request->param('country');
        $limit = $this->request->param('limit');

        $cacheKey = "pm25-station-list-$limit";

        /*
        if ($json = apc_fetch($cacheKey)) {
            header('Content-Type: application/json');
            return $json;
        }
        */

        $args = [];
        $conns = ConnectionManager::getInstance();
        $conn = $conns->get('default');
        $sql = "SELECT id, country, country_en, city, city_en, name, name_en, address, address_en, latitude, longitude FROM stations s ";

        if ($country) {
            $sql .= " WHERE country_en = :country "; // skip Japan because it will be too large
            $args[":country"] = $country;
        } else {
            $sql .= " WHERE country_en = 'Taiwan' OR country_en = 'China'"; // skip Japan because it will be too large
        }
        $sql .= " ORDER BY country ASC, city ASC, name ASC, id DESC";

        if ($limit) {
            $sql .= ' LIMIT ' . intval($limit);
        }

        $stmt = $conn->prepareAndExecute($sql, $args);
        $rows = $stmt->fetchAll();
        foreach($rows as &$row) {
            $row['id'] = intval($row['id']);
            $row['longitude'] = doubleval($row['longitude']);
            $row['latitude'] = doubleval($row['latitude']);
            // $row = array_filter($row);
        }
        $json = $this->toJson($rows);
        apc_store($cacheKey, $json, 60 * 60 * 24);
        return $json;
    }
}
