<?php

$app->get('/bets/api/version', function () use ($app) {
    $info = array (
        "app-name"  => 'bets',
        "app-version" => '0.1.0',
        "app-url"   => 'https://github.com/grigoriev/bets'
    );
    echo json_encode($info);
});

