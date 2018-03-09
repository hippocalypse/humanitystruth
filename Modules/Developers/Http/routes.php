<?php

Route::group(['middleware' => 'web', 'prefix' => 'developers', 'namespace' => 'Modules\Developers\Http\Controllers'], function()
{
    Route::get('/', 'DevelopersController@index');
});
