<?php

/*
 * This file is part of the LOG-VIEWER package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

$router->get('/', function () {
    // Since we have nothing here, just redirect to log view landing page.
    return redirect()->to(route('log.landing'));
});

$router->group(['prefix' => '/log'], function ($router) {
    $router->get('/', [
        'as'   => 'log.landing',
        'uses' => 'LogController@showLanding',
    ]);

    $router->get('/{type}', [
        'as'   => 'log.fetch',
        'uses' => 'LogController@fetchLog',
    ]);
});
