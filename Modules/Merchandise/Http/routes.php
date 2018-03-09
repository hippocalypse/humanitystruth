<?php

Route::group(['middleware' => 'web', 'prefix' => 'merchandise', 'namespace' => 'Modules\Merchandise\Http\Controllers'], function()
{
    Route::get('/', 'MerchandiseController@index');
});
