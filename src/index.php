<?php

use bets\dao\UserSessionManager;

require_once dirname(__FILE__) . '/vendor/Slim/Slim.php';
require_once dirname(__FILE__) . '/bets/Bets.php';

\Slim\Slim::registerAutoloader();
\bets\Bets::registerAutoloader();

$app = new \Slim\Slim();
$app->environment['PATH_INFO'] = $_SERVER['REQUEST_URI'];
$app->contentType('application/json');

$app->get('/', function () use ($app) {
    $app->contentType('text/html; charset=utf-8');
    echo file_get_contents(dirname(__FILE__) . '/gui/main/main.html');
});

$app->get('/login', function () use ($app) {
    $app->contentType('text/html; charset=utf-8');
    echo file_get_contents(dirname(__FILE__) . '/gui/login/login.html');
});

include_once dirname(__FILE__) . '/api/user.php';

include_once dirname(__FILE__) . '/api/version.php';
include_once dirname(__FILE__) . '/api/test.php';

$app->run();