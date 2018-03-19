<?php

Route::group(['middleware' => 'web', 'prefix' => 'securedrop', 'namespace' => 'Modules\SecureDrop\Http\Controllers'], function()
{
    Route::get('/', 'SecureDropController@index')->middleware('tor.check');
    Route::get('/help', 'SecureDropController@help')->name('securedrop.help');
    Route::post('/', 'SecureDropController@store')->middleware('tor.check');
    Route::get('/success', 'SecureDropController@success');
});
