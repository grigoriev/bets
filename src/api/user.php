<?php

$app->get('/bets/api/user/find/id/:id', function ($id) use ($app) {

    $user = \bets\dao\UserManager::instance()->findById($id);

    echo $user->json();
});

$app->get('/bets/api/user/find/name/:name', function ($name) use ($app) {

    $user = \bets\dao\UserManager::instance()->findByName($name);

    echo $user->json();
});
