<?php

$app->get('/bets/api/test', function () use ($app) {

    $user = \bets\dao\UserManager::instance()->findById(2);

    echo $user->json();
});
