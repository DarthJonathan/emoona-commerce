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

/*
 * Front Pages
 */
Route::get('/', 'StoreController@home')->name('index');
Route::get('/store/{category?}', 'StoreController@store')->name('store');
Route::get('/studio', 'StoreController@studio')->name('studio');
Route::get('/social', 'StoreController@social')->name('social');
Route::get('/about', 'StoreController@about')->name('about');
Route::get('/tnc', 'HomeController@termsAndCons')->name('tnc');
Route::get('/return', 'HomeController@returnPolicy')->name('return');
Route::get('/shipping', 'HomeController@shippingPolicy')->name('shipping');
Route::get('/contact', 'HomeController@contactUs')->name('contact');

/*
 * News Letter
 */
Route::post('/newsletter/sign.up', 'HomeController@signUpNewsletter');

/*
 * Products
 */
Route::get('product/{gender}/', 'ProductController@viewCategoryGender');
Route::get('product/{gender}/{category_id}', 'ProductController@viewCategory');
Route::get('product/{gender}/{category_id}/{product_id}', 'ProductController@viewProduct');

// Studio
Route::post('studio/all','StudioFrontController@getStudioData');
Route::get('studio/{id}','StudioFrontController@viewStudioItem');

/*
 * Ajax APIs
 */
    Route::get('products/front.page', 'ProductController@frontPage');
    Route::get('products/category.products', 'ProductController@categoryProducts');
    Route::get('products/category.products_all', 'ProductController@categoryProductsAll');
    Route::get('products/on.sale', 'ProductController@loadOnSale');
    Route::POST('products/notify', 'StoreController@notify');

/*
 * Cart Routes
 */
Route::post('product/add_to_cart','CartController@addToCart');
Route::get('cart','CartController@cart');
Route::post('clear_cart','CartController@clearCart');
Route::post('remove_item','CartController@removeItem');
Route::post('cart/contents_ajax','CartController@getCartContent');
Route::get('cart/contents_ajax','CartController@getCartContent');

/*
 * Authentications
 */
Auth::routes();

Route::get('/activate/{activation_code}', 'Auth\ActivateAccountController@activate');
Route::get('suspended', function()
{
    return view('suspended');
});

/*
 * User Page
 */

Route::middleware(['notifications', 'checkRole', 'suspended', 'auth'])->group(function()
{
    Route::get('/account', 'HomeController@index')->name('profile');
    Route::get('/notifications', 'UserController@notifications')->name('notification');
    Route::get('profile/edit', 'UserController@edit')->name('edit.profile');
    Route::get('/profile', 'StoreController@profile')->name('profile');
    Route::get('/resend_activation', 'UserController@resend')->name('resend');
    Route::post('/update', 'UserController@update')->name('update');
    Route::get('/password.edit', 'UserController@editPassword')->name('edit.password');
    Route::post('/password.edit', 'UserController@storePassword');

    /*
     * Checkout Transaction
     */
    Route::middleware(['cart.check', 'isActivated'])->group(function() {
        Route::get('checkout', 'TransactionController@checkoutCart');
        Route::post('payment', 'TransactionController@payment');
        Route::get('payment.screen', 'TransactionController@paymentScreen');
    });

    Route::get('transfer.information', 'TransactionController@transferInformation');
    Route::get('transactions/{id}', 'TransactionController@transactionDetail');
    Route::post('verify_payment/{id}', 'TransactionController@verifyPayment');
    Route::post('verify_payment_submit', 'TransactionController@verifyPaymentSubmit');
    Route::post('view_payment_proof', 'TransactionController@viewPaymentProof');

    Route::get('order.history', 'TransactionController@orderHistory');
    Route::get('orders', 'TransactionController@pendingOrders');

    /*
     * User Tickets
     */
    Route::get('tickets', 'SupportController@allTickets');
    Route::post('tickets', 'SupportController@getTickets');
    Route::post('tickets/reply.ticket', 'SupportController@replyTicket');
    Route::post('tickets/new.ticket', 'SupportController@newTicket');

    /*
     * Notifications
     */
    Route::get('notification/remove/{id}', 'UserController@removeNotification');

});

/*
 * Admin Routes
 */

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
        Route::get('configuration', 'admin\AdminController@webConfiguration')->name('web_configuration');
        Route::get('newsletter', 'admin\AdminController@newsletter')->name('newsletter');
        Route::get('studio', 'admin\AdminController@studio')->name('studio'); 
        Route::get('social', 'admin\AdminController@social')->name('social'); 

        /**
         * User Data & Passwords
         */
        Route::get('edit_profile', 'admin\AdminController@editProfile');
        Route::get('change_password', 'admin\AdminController@changePassword');
        Route::post('edit_profile', 'admin\AdminController@storeProfile');
        Route::post('change_password', 'admin\AdminController@storePassword');

        /**
         * Ajax Confirmation
         */
        Route::post('confirm_prompt', 'admin\AdminController@prompt');

        /*
         * Webconfiguration
         */
        Route::post('/webconfig/collections_card', 'admin\WebconfigController@collectionsCard');
        Route::post('/webconfig/get_featured', 'admin\WebconfigController@getFeatured');
        Route::post('/webconfig/remove.featured', 'admin\WebconfigController@removeFeatured');
        Route::post('/webconfig/edit.texts', 'admin\WebconfigController@editTexts');
        Route::post('/webconfig/remove.slider', 'admin\WebconfigController@removeSlider');
        Route::post('/webconfig/add_slider_ajax', 'admin\WebconfigController@addSlider');
        Route::post('/webconfig/add_slider', 'admin\WebconfigController@storeSliderImage');
        Route::post('/webconfig/change_collections', 'admin\WebconfigController@changeCollectionImages');
        Route::post('/webconfig/update_transfer_text', 'admin\WebconfigController@changeTransferText');
        Route::post('/webconfig/reorder.slider', 'admin\WebconfigController@reorderSliders');

        /*
         * Item Management
         *
             *
             * Category
             */
        Route::post('category', 'admin\ItemManagement@category');
        Route::post('delete_category', 'admin\ItemManagement@deleteCategory');
        Route::post('edit_category','admin\ItemManagement@editCategory');
        Route::post('edit_category_req','admin\ItemManagement@editCategoryAjax');
        Route::post('new_category','admin\ItemManagement@newCategory');
        Route::post('new_category_req','admin\ItemManagement@newCategoryAjax');
        /*
         * Item
         */
        Route::post('new_item_req', 'admin\ItemManagement@newItemAjax');
        Route::post('new_item', 'admin\ItemManagement@newItem');
        Route::post('edit_item_req', 'admin\ItemManagement@editItemAjax');
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
        Route::post('items/sales_status', 'admin\ItemManagement@salesStatus');
        Route::post('items/save_sales', 'admin\ItemManagement@storeSale');
        Route::post('items/remove_sale', 'admin\ItemManagement@removeSale');

        /*
         * Account Management
         */
        Route::post('userinfo', 'admin\UserManagementController@userinfo');
        Route::post('make.admin', 'admin\UserManagementController@makeAdmin');
        Route::post('demote.admin', 'admin\UserManagementController@demoteAdmin');
        Route::post('user_transactions', 'admin\UserManagementController@userTransactions');
        Route::post('user_transaction_detail', 'admin\UserManagementController@userTransactionDetails');
        Route::post('suspend', 'admin\UserManagementController@suspend');
        Route::post('delete_confirmation', 'admin\AdminController@confirmDelete');
        Route::post('remove', 'admin\UserManagementController@removeUser');

        /*
         * Transactions
         */
        Route::post('get_transactions', 'admin\TransactionController@getAll');
        Route::post('confirm_payment', 'admin\TransactionController@confirmPayment');
        Route::post('add_tracking_code_req', 'admin\TransactionController@addTrackingCodeAjax');
        Route::post('add_tracking_code', 'admin\TransactionController@addTrackingCode');
        Route::post('view_payment_proof', 'TransactionController@viewPaymentProof');

        /*
         *  Support
         */
        Route::post('open_ticket_req', 'admin\SupportController@openTicketAjax');
        Route::post('open_ticket', 'admin\SupportController@openTicket');
        Route::post('reply_ticket_req', 'admin\SupportController@replyTicketAjax');
        Route::post('reply_ticket', 'admin\SupportController@replyTicket');
        Route::post('get_tickets', 'admin\SupportController@getTickets');
        Route::post('complete_ticket', 'admin\SupportController@completeTicket');

        /*
         * Newsletter
         */
        Route::get('newsletter/new.newsletter', 'admin\NewsletterController@newNewsletter');
        Route::post('newsletter/view.content', 'admin\NewsletterController@viewContent');

        /*
         * Social 
         */
        Route::post('social/save_images','admin\SocialController@saveImages'); 
        Route::get('social/remove/{id}', 'admin\SocialController@removeImage'); 
 
        /*
         * Studio 
         */
        Route::post('studio/createCategory','admin\StudioController@createCategory'); 
        Route::get('studio/deleteCategory/{id}','admin\StudioController@deleteCategory'); 
        Route::post('studio/editCategory/{id}','admin\StudioController@editCategoryView'); 
        Route::post('studio/editCategory/','admin\StudioController@editCategory'); 
        Route::post('studio/getCategory','admin\StudioController@getCategory'); 
        Route::post('studio/addStudioItem','admin\StudioController@addStudioItem');
        Route::get('studio/deleteItem/{id}','admin\StudioController@deleteStudioItem');  
    });
});


/*
 * Image Serving Route
 */

Route::get('storage/{path}', function($path){

    $path = storage_path('app/public/' . $path);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;

})->where('path','.+');