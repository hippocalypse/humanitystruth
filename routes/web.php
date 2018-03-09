<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::get('verifyemail/{token}', 'Auth\RegisterController@verify');

Route::get('/', function () { return view('index'); })->name('home');

/* Investigations */
Route::get('investigations', 'InvestigationController@index');
Route::get('investigations/{investigation}', 'InvestigationController@show');
Route::get('investigations/new', 'InvestigationController@create');

/* Files */
Route::get('files', 'FileController@index');
Route::get('files/{file}', 'FileController@show');
Route::get('files/new', 'FileController@create');

/* Client-side*/
Route::get('dashboard', 'DashboardController@index')->name('dashboard');


/* Backend */
Route::group(['prefix' => 'admins'], function () {
    Route::get('/', 'AdminController@index')->name('admins');
    Route::get('affiliates', 'AdminController@affiliatesView')->name('admin.affiliatesView');
    Route::post('affiliates', 'AdminController@affiliatesSave')->name('admin.affiliatesSave');
    Route::get('affiliates/remove/{id}', 'AdminController@affiliatesRemove');
});


/* Dev-Team 
Route::get('dev-team', 'Modules/Developers/Http/Controllers/DevelopersController@index');*/



/* Affiliates */
Route::get('affiliates', function() {
    $affiliates = Affiliate::all();
    return view('affiliates', compact("affiliates"));   
});

Route::get('site-map', function () {
    return view('sitemap');
});

Route::get('contact', function () {
    return view('contact');
});

Route::get('donate', function () {
    return view('donate');
});

Route::get('download', function () {
    return view('download');
});

Route::get('ethics-policy', function () {
    return view('ethics');
});

Route::get('join', function () {
    return view('join');
});