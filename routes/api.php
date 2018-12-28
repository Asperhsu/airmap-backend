<?php

Route::get('icon/{value}', 'ApiController@makeIcon')->name('pm25icon');
Route::get('nearby', 'ApiController@searchNearBy');
Route::get('shortcut/{keyword}', 'ShortcutController@search');

/* JSON */
Route::group(['prefix' => 'json', 'middleware' => 'cors'], function () {
    Route::get('airmap.json', 'JsonController@airmap');
    Route::get('townmap.json', 'JsonController@townmap');
    Route::get('{json}', 'JsonController@group')
        ->where('json', '.*\.json$')->name('json');

    Route::get('query-lastest', 'JsonController@lastest');
    Route::get('query-history', 'JsonController@history');
    Route::get('query-prediction', 'JsonController@prediction');

    Route::get('query-region', 'JsonController@region');
    Route::get('query-bounds', 'JsonController@bounds');
});
