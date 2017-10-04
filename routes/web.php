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
})->name('home');

Auth::routes();

Route::get('/activate/{activation_code}', 'Auth\ActivateAccountController@activate');
Route::get('suspended', function()
{
    return view('suspended');
});

Route::middleware(['notifications', 'checkRole', 'suspended'])->group(function()
{
    Route::get('/home', 'HomeController@index')->name('profile');
    Route::get('/notifications', 'UserController@notifications')->name('notification');
    Route::get('profile/edit', 'UserController@edit')->name('editprofile');
    Route::get('/resend_activation', 'UserController@resend')->name('resend');
    Route::post('/update', 'UserController@update')->name('update');
});

/*
 * Image Serving Route
 */

Route::get('storage/{folder}/{filename}', function ($folder, $filename)
{
    $path = storage_path('app/public/' . $folder . '/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::middleware(['admin'])->group(function()
{
    Route::get('admin', 'admin\AdminController@dashboard')->name('admindashboard');

    Route::prefix('admin')->group(function () {
        /*
         * Normal Routes
         */
        Route::get('accounts', 'admin\AdminController@accounts')->name('accounts');
        Route::get('items', 'admin\AdminController@items')->name('storeitems');
        Route::get('transaction', 'admin\AdminController@transactions')->name('transactions');
        Route::get('tickets', 'admin\AdminController@tickets')->name('tickets');

        /*
         * Item Management
         *
             *
             * Category
             */
        Route::post('category', 'admin\ItemManagement@category');
        Route::post('delete_category', 'admin\ItemManagement@deleteCategory');
            /*
            * Item
            */
        Route::post('new_item_req', 'admin\ItemManagement@newItemAjax');
        Route::post('new_item', 'admin\ItemManagement@newItem');
        Route::post('edit_item_req', 'admin\ItemManagement@editItemAjax');
        Route::get('edit_item_req', 'admin\ItemManagement@editItemAjax');
        Route::post('edit_item', 'admin\ItemManagement@editItem');
        Route::post('delete_item', 'admin\ItemManagement@deleteItem');
            /*
            *  Item Detail
            */
        Route::post('new_item_detail_req', 'admin\ItemManagement@newItemDetailAjax');
        Route::post('new_item_detail', 'admin\ItemManagement@newItemDetail');
        Route::post('edit_item_detail', 'admin\ItemManagement@editItemDetailAjax');
        Route::post('edit_item_detail_image_req', 'admin\ItemManagement@editItemDetailImageAjax');
        Route::post('delete_item_detail', 'admin\ItemManagement@deleteItemDetail');
        Route::post('delete_image', 'admin\ItemManagement@deleteItemDetailImage');
        Route::post('add_image_item_detail', 'admin\ItemManagement@addImageItemDetail');
        Route::get('add_image_item_detail', 'admin\ItemManagement@addImageItemDetail');

        /*
         * Account Management
         */
        Route::post('userinfo', 'admin\UserManagementController@userinfo');
        Route::post('user_transactions', 'admin\UserManagementController@userTransactions');
        Route::post('user_transaction_detail', 'admin\UserManagementController@userTransactionDetails');
        Route::post('suspend', 'admin\UserManagementController@suspend');
        Route::post('delete_confirmation', 'admin\AdminController@confirmDelete');
        Route::post('remove', 'admin\UserManagementController@removeUser');
    });
});

