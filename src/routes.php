<?php


use Illuminate\Support\Facades\Route;
use Laralog\Laralog\LaralogMiddleware;
use Laralog\Laralog\HandleCors;

Route::group(['prefix' => 'laralog'], function () {
    Route::get('/available/logs', 'Laralog\Laralog\LogController@getAvailableLogs')
        ->middleware([HandleCors::class, LaralogMiddleware::class]);
    
    Route::get('/get/log', 'Laralog\Laralog\LogController@getLog')
        ->middleware([HandleCors::class, LaralogMiddleware::class]);
});
