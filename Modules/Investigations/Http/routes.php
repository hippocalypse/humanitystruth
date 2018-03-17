<?php

Route::group(['middleware' => 'web', 'prefix' => 'investigations', 'namespace' => 'Modules\Investigations\Http\Controllers'], function()
{
    Route::get('/', 'InvestigationsController@index');
    Route::get('/{investigation}', 'InvestigationsController@show');
    Route::get('/new', 'InvestigationsController@create');

});
