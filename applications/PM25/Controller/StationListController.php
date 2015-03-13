<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\StationCollection;
use LazyRecord\ConnectionManager;

class StationListController extends Controller
{
    public function indexAction() {
        $limit = $this->request->param('limit');
        $conns = ConnectionManager::getInstance();
        $conn = $conns->get('default');
        $sql = 'SELECT id, country, country_en, city, city_en, name, name_en, address, address_en, latitude, longitude 
            FROM stations s 
            ORDER BY country ASC, city ASC, name ASC, id DESC';
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
        return $this->toJson($rows);
    }
}
