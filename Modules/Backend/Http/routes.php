<?php

Route::group(['middleware' => 'web', 'prefix' => 'backend', 'namespace' => 'Modules\Backend\Http\Controllers'], function()
{
    Route::get('/', 'BackendController@index')->name('admins');
    Route::get('affiliates', 'BackendController@affiliatesView')->name('admin.affiliatesView');
    Route::post('affiliates', 'BackendController@affiliatesSave')->name('admin.affiliatesSave');
    Route::get('affiliates/remove/{id}', 'BackendController@affiliatesRemove');
});
