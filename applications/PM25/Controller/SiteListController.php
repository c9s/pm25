<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\SiteCollection;
use LazyRecord\ConnectionManager;

class SiteListController extends Controller
{
    public function indexAction() {
        $conns = ConnectionManager::getInstance();
        $conn = $conns->get('default');
        $stmt = $conn->prepareAndExecute('SELECT s.id, s.country, s.country_en, s.city, s.city_en, s.name, s.name_en, s.longitude, s.latitude, s.address, s.address_en FROM sites s');
        $rows = $stmt->fetchAll();
        foreach($rows as &$row) {
            $row['id'] = intval($row['id']);
        }
        return $this->toJson($rows);
    }
}
