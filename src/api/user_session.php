<?php

use bets\dao\UserSessionManager;
use bets\model\UserSession;
use bets\utils\URL;

$app->get(URL::BETS_API_USER_SESSION_NEW . ':username', function ($username) use ($app) {
    $user_session = new UserSession();
    $user_session->username = $username;
    $user_session->ip_address = $app->request->getIp();
    echo UserSessionManager::instance()->create($user_session)->json();
});

$app->get(URL::BETS_API_USER_SESSION_FIND_UUID . ':uuid', function ($uuid) use ($app) {
    echo UserSessionManager::instance()->findById($uuid)->json();
});

$app->get(URL::BETS_API_USER_SESSION_FIND_USERNAME . ':username', function ($username) use ($app) {
    echo json_encode(UserSessionManager::instance()->findByUsername($username));
});
