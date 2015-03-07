<?php
namespace PM25\Controller;
use Phifty\Controller;
use PM25\Model\SiteCollection;

class SiteListController extends Controller
{
    public function indexAction() {
        $sites = new SiteCollection;
        return $sites->toJson();
    }
}
