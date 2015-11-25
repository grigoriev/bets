<?php

use bets\dao\UserManager;
use bets\model\User;

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
