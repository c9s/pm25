<?php
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
header('X-FRAME-OPTIONS:SAMEORIGIN');
header('Pragma:No-cache');
header('Cache-Control: no-cache');
header('Expires: 0');
/**
 * Front-end script for nginx/apache/fastcgi http server
 *
 * @author c9s <cornelius.howl@gmail.com>
 * @package Phifty
 */
$pathinfo = isset($_SERVER['PATH_INFO']) && $_SERVER["PATH_INFO"] ? $_SERVER['PATH_INFO'] : '/';

use Funk\Environment;
use Funk\Responder\SAPIResponder;
use Phifty\Routing\RouteExecutor;

try {
    require '../bootstrap.php';
    global $kernel;


    $kernel->event->trigger('phifty.before_path_dispatch');
    if ($route = $kernel->rootMux->dispatch($pathinfo)) {
        $kernel->event->trigger('phifty.before_page');

        $environment = Environment::createFromGlobals();

        $response = [];
        $response = RouteExecutor::execute($route, $environment, $response, $route);
        $responder = new SAPIResponder;
        $responder->respond($response);

        $kernel->event->trigger('phifty.after_page');
    } else {
        @header('HTTP/1.0 404 Not Found');
        echo "<h3>Page not found.</h3>";
    }
}
catch ( Roller\Exception\RouteException $e ) {
    header('HTTP/1.1 403');
    die( $e->getMessage() );
}

