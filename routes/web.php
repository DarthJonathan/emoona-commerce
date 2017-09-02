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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('notifications');

Route::middleware(['notifications'], function()
{
    Route::get('/notifications', 'UserController@notifications')->name('Notifications');
    Route::get('profile/edit', 'UserController@edit')->name('Edit Profile');
});
