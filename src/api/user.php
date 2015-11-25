<?php

use bets\dao\UserManager;
use bets\dao\UserSessionManager;
use bets\model\User;
use bets\model\UserSession;

$app->get('/bets/api/user/new/:username/:password/:first_name/:last_name/:email', function ($username, $password, $first_name, $last_name, $email) use ($app) {
    $user = new User();
    $user->username = $username;
    $user->password = md5($password);
    $user->first_name = $first_name;
    $user->last_name = $last_name;
    $user->email = $email;
    echo UserManager::instance()->create($user)->json();;
});

$app->get('/bets/api/user/find/username/:username', function ($username) use ($app) {
    echo UserManager::instance()->findById($username)->json();
});

$app->get('/bets/api/user/authenticate/:username/:password', function ($username, $password) use ($app) {
    $authenticated = UserManager::instance()->authenticate($username, $password);
    if ($authenticated === true) {
        $user_session = new UserSession();
        $user_session->username = $username;
        $user_session->ip_address = $app->request->getIp();

        $user_session = UserSessionManager::instance()->create($user_session);

        $user_session->json();
    } else {
        echo (new UserSession())->json();
    }
});
