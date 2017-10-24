<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
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
