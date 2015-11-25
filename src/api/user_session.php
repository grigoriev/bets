<?php

use bets\dao\UserSessionManager;
use bets\model\UserSession;

$app->post('/bets/api/user/session/new/:username', function ($username) use ($app) {
    $user_session = new UserSession();
    $user_session->username = $username;
    $user_session->ip_address = $app->request->getIp();
    echo UserSessionManager::instance()->create($user_session)->json();
});

$app->get('/bets/api/user/session/find/uuid/:uuid', function ($uuid) use ($app) {
    echo UserSessionManager::instance()->findById($uuid)->json();
});

$app->get('/bets/api/user/session/find/username/:username', function ($username) use ($app) {
    echo json_encode(UserSessionManager::instance()->findByUsername($username));
});
