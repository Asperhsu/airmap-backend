<?php

Route::domain('list.' . config('app.domain'))->group(function () {
    Route::get('/', 'ListController@index')->name('list');
});

Route::domain(config('app.domain'))->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/recruit', 'HomeController@recruit')->name('recruit');

    Route::group(['prefix' => 'screenshot'], function () {
        Route::get('/', 'ScreenshotController@index')->name('screenshot.index');
        Route::get('gif', 'ScreenshotController@gif')->name('screenshot.gif');
    });
});

// Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
