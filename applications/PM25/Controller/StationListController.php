<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\StationCollection;
use LazyRecord\ConnectionManager;

class StationListController extends Controller
{
    public function indexAction() {
        $conns = ConnectionManager::getInstance();
        $conn = $conns->get('default');
        $stmt = $conn->prepareAndExecute('SELECT * FROM stations s ORDER BY country ASC, city ASC, name ASC, id DESC');
        $rows = $stmt->fetchAll();
        foreach($rows as &$row) {
            $row['id'] = intval($row['id']);
            $row['longitude'] = doubleval($row['longitude']);
            $row['latitude'] = doubleval($row['latitude']);
        }
        return $this->toJson($rows);
    }
}
