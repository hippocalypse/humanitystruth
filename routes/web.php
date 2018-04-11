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

/* Standard login/registration routes */
Auth::routes();

/* Email and phone verification routes */
Route::get('verifyemail/{token}', 'Auth\RegisterController@verify');
Route::get('two-step', 'Auth\LoginController@show2FAForm');
Route::post('two-step', 'Auth\LoginController@verify');

/* Newsletter Subscriptions */
Route::get('newsletter/subscribe/{email}/{token}', 'NewsletterSubscriptionController@verify');
Route::post('newsletter/subscribe', 'NewsletterSubscriptionController@create');
Route::delete('newsletter/subscribe', 'NewsletterSubscriptionController@destroy');

/* Homepage */
Route::get('/', function () {return view('index');})->name('home');

Route::get('chat', function() {
    return view('chat');
});

/* working on Instant Messaging with Admin */
Route::get('fire', function() {
    event(new \App\Events\ChatMessage("hello!"));
    return "done";
}); 






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
})->name("ethics");

Route::get('join', function () {
    return view('join');
});