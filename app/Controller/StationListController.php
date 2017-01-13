<?php
namespace App\Controller;
use Phifty\Controller;
use App\Model\StationCollection;
use App\Predicate;
use LazyRecord\ConnectionManager;

class StationListController extends Controller
{
    public function indexAction() {
        $keyword = $this->request->param('keyword');
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
        $sql = "SELECT id, country, country_en, city, city_en, name, name_en, county, county_en, address, address_en, latitude, longitude FROM stations s ";

        $predicates = [];

        if ($keyword) {
            $predicates[] = new Predicate('(name LIKE :pat OR name_en LIKE :pat OR city LIKE :pat OR city_en LIKE :pat OR county LIKE :pat OR address LIKE :pat OR address_en LIKE :pat)', [ ':pat' => '%' . $keyword . '%' ]);
        }

        if ($country) {
            $predicates[] = new Predicate('country_en = :country', [ ':country' => $country ]);
        } else {
            $predicates[] = new Predicate("country_en = 'Taiwan' OR country_en = 'China'");
        }

        if (count($predicates)) {
            $sql .= ' WHERE '  . Predicate::mergeConditions($predicates);
        }

        $sql .= " ORDER BY country ASC, city ASC, name ASC, id DESC";

        if ($limit) {
            $sql .= ' LIMIT ' . intval($limit);
        }

        $stmt = $conn->prepareAndExecute($sql, Predicate::mergeArguments($predicates));
        $rows = $stmt->fetchAll();
        foreach($rows as &$row) {
            $row['id'] = intval($row['id']);
            $row['longitude'] = doubleval($row['longitude']);
            $row['latitude'] = doubleval($row['latitude']);
            $row = array_filter($row);
        }
        $json = $this->toJson($rows);
        apc_store($cacheKey, $json, 60 * 60 * 24);
        return $json;
    }
}
