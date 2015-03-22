<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\Station;
use PM25\Model\StationCollection;
use PM25\Model\MeasureCollection;

class StationDetailController extends Controller
{
    public function indexAction($id) {
        $enableMeasurementsArray = $this->request->param('measurements');
        if ($enableMeasurementsArray === NULL) {
            $enableMeasurementsArray = 1;
        }
        $enableSummary = $this->request->param('summary');

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

            if ($enableMeasurementsArray) {
                $measurements = array();
                $measures = new MeasureCollection;
                $measures->where()
                    ->equal('station_id', $station->id);
                $measures->order('published_at', 'DESC');
                $measures->limit(36);
                foreach($measures as $measure) {
                    $array = $measure->toArray();
                    unset($array['station_id']);
                    $measurements[] = $array;
                }

                // register measurements data to the json object
                $data['measurements']  = $measurements;
            }
            unset($data['location']);
            return $this->toJson($data);
        } else {
            return $this->toJson([ 'error' => 'Station not found' ]);
        }
    }
}
