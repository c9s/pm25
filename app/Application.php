<?php
namespace App;
use Phifty\Bundle;

class Application extends Bundle
{
    public function init() {
        $this->route('/current', 'CurrentController');
        $this->route('/stations', 'StationListController');
        $this->route('/stations/nearby/:latitude/:longitude', 'NearbyStationController');
        $this->route('/station/:id', 'StationDetailController');
    }
}




