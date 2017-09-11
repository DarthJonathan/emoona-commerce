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

Route::get('/activate/{activation_code}', 'Auth\ActivateAccountController@activate');
Route::get('suspended', function()
{
    return view('suspended');
});

Route::middleware(['notifications', 'checkRole', 'suspended'])->group(function()
{
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/notifications', 'UserController@notifications')->name('notification');
    Route::get('profile/edit', 'UserController@edit')->name('editprofile');
    Route::get('/resend_activation', 'UserController@resend')->name('resend');
    Route::post('/update', 'UserController@update')->name('update');
});

Route::middleware(['admin'])->group(function()
{
    Route::get('admin', 'admin\AdminController@dashboard')->name('Dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('accounts', 'admin\AdminController@accounts')->name('acconuntmanagement');
        Route::get('items', 'admin\AdminController@items');
        Route::post('category', 'admin\ItemManagement@category');
        Route::get('category', 'admin\ItemManagement@category');
        Route::post('userinfo', 'admin\UserManagementController@userinfo');
        Route::post('user_transactions', 'admin\UserManagementController@userTransactions');
        Route::post('user_transaction_detail', 'admin\UserManagementController@userTransactionDetails');
        Route::post('suspend', 'admin\UserManagementController@suspend');
        Route::post('delete_confirmation', 'admin\UserManagementController@confirmDelete');
        Route::post('remove', 'admin\UserManagementController@removeUser');
    });
});

