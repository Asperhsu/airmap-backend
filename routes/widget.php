<?php

Route::get('api/site-json/{group}${uuid}', 'WidgetController@apiSiteJson')->middleware('cors');
Route::get('create/{group}${uuid}', 'WidgetController@create')->name('widget.create');
Route::get('{type}/{group}${uuid}', 'WidgetController@show')->name('widget.show');
Route::get('/', 'WidgetController@index')->name('widget.index');
