<?php

use bets\Bets;
use bets\dao\UserSessionManager;
use Slim\Route;
use Slim\Slim;

require_once dirname(__FILE__) . '/vendor/Slim/Slim.php';
require_once dirname(__FILE__) . '/bets/Bets.php';

Slim::registerAutoloader();
Bets::registerAutoloader();

$app = new Slim();
$app->environment['PATH_INFO'] = $_SERVER['REQUEST_URI'];
$app->contentType('application/json');


function isValidApiKey($api_key)
{
    return false;
}

function authenticate(Route $route)
{
    $app = Slim::getInstance();

    if (isset($_COOKIE['session-uuid']) && isset($_COOKIE['session-username']) && isset($_COOKIE['session-ip-address'])) {
        $uuid = $_COOKIE['session-uuid'];
        $username = $_COOKIE['session-username'];
        $ip_address = $_COOKIE['session-ip-address'];

        $userSession = UserSessionManager::instance()->findByUsernameAndIpAddress($username, $ip_address);
        if ($userSession->uuid !== $uuid) {
            $app->redirect('/login');
        }
    } else {
        $app->redirect('/login');
    }
}

function response($status_code, $response)
{
    $app = Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}

$app->get('/', 'authenticate', function () use ($app) {
    $app->contentType('text/html; charset=utf-8');
    echo file_get_contents(dirname(__FILE__) . '/gui/main/main.html');
});

$app->get('/login', function () use ($app) {
    $app->contentType('text/html; charset=utf-8');
    echo file_get_contents(dirname(__FILE__) . '/gui/login/login.html');
});

include_once dirname(__FILE__) . '/api/user.php';
include_once dirname(__FILE__) . '/api/user_session.php';

include_once dirname(__FILE__) . '/api/version.php';
include_once dirname(__FILE__) . '/api/test.php';

$app->run();