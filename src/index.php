<?php
require_once(dirname(__FILE__) . '/bets/vendor/Slim/Slim.php');

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->environment['PATH_INFO'] = $_SERVER['REQUEST_URI'];

$app->get('/', function () use ($app) {
    $app->contentType('text/html; charset=utf-8');
});

$app->get('/bets/api/version', function () use ($app) {
    $app->contentType('application/json');
    $info = array (
        "app-name"  => 'bets',
        "app-version" => '0.1.0',
        "app-url"   => 'https://github.com/grigoriev/bets'
    );
    echo json_encode($info);
});

$app->run();