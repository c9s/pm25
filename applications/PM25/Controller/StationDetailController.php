<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\Station;
use PM25\Model\StationCollection;

class StationDetailController extends Controller
{
    public function indexAction($id) {
        $station = new Station;
        if (is_numeric($id)) {
            $station->load(intval($id));
        } else {
            $stations = new StationCollection;
            $stations->where()
                ->equal('name', $id)
                ->or()
                ->equal('city', $id);
            $station = $stations->first();
        }
        if ($station) {
            $data = $station->toArray();
            $data['longitude'] = doubleval($data['longitude']);
            $data['latitude'] = doubleval($data['latitude']);
            $data['id'] = doubleval($data['id']);
            return $this->toJson($data);
        } else {
            return $this->toJson([ 'error' => 'Station not found' ]);
        }
    }
}
