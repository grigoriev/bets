<?php

use bets\dao\UserManager;
use bets\dao\UserSessionManager;
use bets\model\User;
use bets\model\UserSession;
use bets\utils\URL;

$app->get(URL::BETS_API_USER_NEW . ':username/:password/:first_name/:last_name/:email', function ($username, $password, $first_name, $last_name, $email) use ($app) {
    $user = new User();
    $user->username = $username;
    $user->password = md5($password);
    $user->first_name = $first_name;
    $user->last_name = $last_name;
    $user->email = $email;
    echo UserManager::instance()->create($user)->json();;
});

$app->get(URL::BETS_API_USER_FIND_USERNAME . ':username', function ($username) use ($app) {
    echo UserManager::instance()->findById($username)->json();
});

$app->get(URL::BETS_API_USER_AUTHENTICATE . ':username/:password', function ($username, $password) use ($app) {
    $authenticated = UserManager::instance()->authenticate($username, $password);
    if ($authenticated === true) {
        $user_session = new UserSession();
        $user_session->username = $username;
        $user_session->ip_address = $app->request->getIp();

        $user_session = UserSessionManager::instance()->create($user_session);

        echo $user_session->json();
    } else {
        echo (new UserSession())->json();
    }
});

$app->get(URL::BETS_API_USER_LOGOUT . ':uuid/:username', function ($uuid, $username) use ($app) {
    $user_session = UserSessionManager::instance()->findByUsernameAndIpAddress($username, $app->request->getIp());
    if ($user_session->uuid === $uuid) {
        UserSessionManager::instance()->delete($user_session);
    }
});
