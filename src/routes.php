<?php


use Illuminate\Support\Facades\Route;
use Laralog\Laralog\LaralogMiddleware;
use Barryvdh\Cors\HandleCors;

Route::prefix('/laralog')->group(function () {
    Route::get('/available/logs', 'Laralog\Laralog\LogController@getAvailableLogs')
        ->middleware([HandleCors::class, LaralogMiddleware::class]);
    
    Route::get('/get/log', 'Laralog\Laralog\LogController@getLog')
        ->middleware([HandleCors::class, LaralogMiddleware::class]);
});
