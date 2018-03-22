<?php

Route::group(['middleware' => 'web', 'prefix' => 'lightworkersunion', 'namespace' => 'Modules\LightworkersUnion\Http\Controllers'], function()
{
    Route::get('/', 'LightworkersUnionController@index');
});
