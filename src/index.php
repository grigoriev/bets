<?php

use bets\Bets;
use bets\dao\UserSessionManager;
use bets\exceptions\NotAuthenticatedException;
use bets\utils\StringUtils;
use bets\utils\URL;
use Slim\Slim;

require_once dirname(__FILE__) . '/vendor/Slim/Slim.php';
require_once dirname(__FILE__) . '/bets/Bets.php';

Slim::registerAutoloader();
Bets::registerAutoloader();

$app = new Slim();
$app->environment['PATH_INFO'] = $_SERVER['REQUEST_URI'];
$app->contentType('application/json');

function userIsNotAuthenticated($pattern)
{
    if ($pattern === URL::INDEX) {
        Slim::getInstance()->redirect(URL::LOGIN);
    } else {
        throw new NotAuthenticatedException('not authenticated');
    }
}

$app->hook('slim.before.dispatch', function () {
    $pattern = Slim::getInstance()->router()->getCurrentRoute()->getPattern();

    $urlsWithoutAuthentication = array(
        URL::LOGIN,
        URL::BETS_API_USER_AUTHENTICATE,
    );

    foreach ($urlsWithoutAuthentication as $url) {
        if (StringUtils::startsWith($pattern, $url)) {
            return;
        }
    }

    if (isset($_COOKIE['session-uuid']) && isset($_COOKIE['session-username']) && isset($_COOKIE['session-ip-address'])) {
        $uuid = $_COOKIE['session-uuid'];
        $username = $_COOKIE['session-username'];
        $ip_address = $_COOKIE['session-ip-address'];

        $user_session = UserSessionManager::instance()->findByUsernameAndIpAddress($username, $ip_address);

        if ($user_session->uuid !== $uuid) {
            userIsNotAuthenticated($pattern);
        }
    } else {
        userIsNotAuthenticated($pattern);
    }
});

$app->get(URL::INDEX, function () use ($app) {
    $app->contentType('text/html; charset=utf-8');
    echo file_get_contents(dirname(__FILE__) . '/gui/main/main.html');
});

$app->get(URL::LOGIN, function () use ($app) {
    $app->contentType('text/html; charset=utf-8');
    echo file_get_contents(dirname(__FILE__) . '/gui/login/login.html');
});

include_once dirname(__FILE__) . '/api/user.php';
include_once dirname(__FILE__) . '/api/user_session.php';

include_once dirname(__FILE__) . '/api/version.php';
include_once dirname(__FILE__) . '/api/test.php';

$app->run();