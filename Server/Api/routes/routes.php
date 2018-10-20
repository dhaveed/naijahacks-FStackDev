<?php

// API
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Origin: *');

$app->group('/v1', function () use ($app) {

    $app->group('/admin', function () use ($app) {
        $app->get('/testing', App\Controllers\TestingController::class)->setName('testing');

        $app->group('/auth', function() use ($app){
            $app->post('/login', App\Controllers\AdminAuthController::class . ':login');
            $app->get('/logout', App\Controllers\AdminAuthController::class . ':logout');
            $app->get('/session', App\Controllers\AdminAuthController::class . ':session');
            $app->get('/isli', App\Controllers\AdminAuthController::class . ':userIsLoggedIn');
        });

        $app->group('/clients', function() use ($app){
            $app->post('/all', App\Controllers\CustomersController::class . ':all');
        });
    });   

    $app->group('/clients', function () use ($app){
        $app->post('/test', App\Controllers\UserAuthController::class . ':test');
        $app->post('/register', App\Controllers\UserAuthController::class . ':register');
        $app->post('/login', App\Controllers\UserAuthController::class . ':login');
        $app->get('/logout', App\Controllers\UserAuthController::class . ':logout');
        $app->get('/session', App\Controllers\UserAuthController::class . ':session');
        $app->get('/isuserlogged', App\Controllers\UserAuthController::class . ':userIsLoggedIn');
    });
});
