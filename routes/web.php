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
Route::get('/activate/{activation_code}', 'Auth\ActivateAccountController@activate');

Route::middleware(['notifications'])->group(function()
{
    Route::get('/notifications', 'UserController@notifications')->name('notification');
    Route::get('profile/edit', 'UserController@edit')->name('editprofile');
    Route::get('/resend_activation', 'UserController@resend')->name('resend');
});

Route::middleware(['admin'])->group(function()
{
    Route::get('admin', 'admin\AdminController@dashboard')->name('Dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('items', function () {
            // Matches The "/admin/users" URL
        });
    });
});

