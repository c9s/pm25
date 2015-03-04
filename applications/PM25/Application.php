<?php
namespace PM25;
use Phifty\Bundle;

class Application extends Bundle
{
    public function init() {
        $this->route('/current', 'CurrentController');
    }
}




