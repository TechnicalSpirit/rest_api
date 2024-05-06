<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () {
    echo "It’s good that this page appeared, but this application is needed for REST API";
});

$router->group(['prefix' => 'loans', 'namespace' => 'API'], function () use ($router) {
    $router->get('/', 'LoanController@index');
    $router->post('/', 'LoanController@create');
    $router->get('/{id}', 'LoanController@show');
    $router->put('/{id}', 'LoanController@update');
    $router->delete('/{id}', 'LoanController@destroy');
});
