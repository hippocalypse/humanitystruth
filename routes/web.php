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

Route::get('/', function () {return view('index');})->name('home');


/* Client-side*/
Route::get('dashboard', 'DashboardController@index')->name('dashboard');


/* Affiliates */
Route::get('affiliates', function() {
    $affiliates = \App\Affiliate::all();
    return view('affiliates', compact("affiliates"));   
});

/* Sitemap */
Route::get('sitemap', function () {
    $routes = Route::getRoutes();
    return view('sitemap', compact("routes"));
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