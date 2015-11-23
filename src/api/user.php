<?php

use bets\dao\UserManager;

$app->get('/bets/api/user/find/id/:id', function ($id) use ($app) {
    $user = UserManager::instance()->findById($id);
    echo $user->json();
});

$app->get('/bets/api/user/find/name/:name', function ($name) use ($app) {
    $user = UserManager::instance()->findByName($name);
    echo $user->json();
});
