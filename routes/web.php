<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\AdminCartController;

use App\Http\Controllers\Admin\SupplierController;
// use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\InvoiceController;
use Laravel\Cashier\Http\Controllers\WebhookController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\AuthController;


Route::get('/order-statistics', [MainController::class, 'showOrderStatistics']);
Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);
#login_person
Route::get('/admin/home', [MainController::class, 'index'])->name('admin.home');



Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('admin/supplier/list', [ProductController::class, 'index']);


        #Menu
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);
            Route::post('add', [MenuController::class, 'store']);
            Route::get('list', [MenuController::class, 'index']);
            Route::get('edit/{menu}', [MenuController::class, 'show']);
            Route::post('edit/{menu}', [MenuController::class, 'update']);
            Route::DELETE('destroy', [MenuController::class, 'destroy']);
        });

        #supplier
        Route::prefix('supplier')->group(function () {
            Route::get('add', [SupplierController::class, 'create']);
            Route::post('add', [SupplierController::class, 'store']);
            Route::get('edit/{list_suppliers}', [SupplierController::class, 'show']);
            Route::post('edit/{list_suppliers}', [SupplierController::class, 'update']);
            Route::DELETE('destroy', [SupplierController::class, 'destroy']);
        });
        #Product
        Route::prefix('products')->group(function () {
            Route::get('add', [ProductController::class, 'create']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('list', [ProductController::class, 'index']);
            Route::get('edit/{product}', [ProductController::class, 'show']);
            Route::post('edit/{product}', [ProductController::class, 'update']);
            Route::DELETE('destroy', [ProductController::class, 'destroy']);
        });

        #Slider
        Route::prefix('sliders')->group(function () {
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'edit']);  // Sửa 'show' thành 'edit'
            Route::put('edit/{slider}', [SliderController::class, 'update']); // Sử dụng 'put' thay vì 'post' cho việc cập nhật
            Route::delete('destroy/{slider}', [SliderController::class, 'destroy']); // Thêm tham số {slider} để xác định slider cần xóa
        });

        #Upload
        Route::post('upload/services', [\App\Http\Controllers\Admin\UploadController::class, 'store']);
        Route::get('/uploads/{services}', [\App\Http\Controllers\Admin\UploadController::class, 'displayImage'])->name('uploads.display');

        #Cart
        Route::get('invoice/{id}', 'InvoiceController@generateInvoice');

        Route::get('customers', [\App\Http\Controllers\Admin\CartController::class, 'index']);
        Route::get('customers/view/{customer}', [\App\Http\Controllers\Admin\CartController::class, 'show']);
        // Route::get('customers/confirm/{customer}', [\App\Http\Controllers\Admin\CartController::class, 'confirm']);
        Route::get('customers/confirm/{customer}', [\App\Http\Controllers\Admin\CartController::class, 'confirm'])->name('admin.customers.confirm');
        Route::get('admin/carts/approve/{id}', [\App\Http\Controllers\AdminCartController::class, 'approve'])->name('admin.carts.approve');
        Route::get('admin/carts/refuse/{id}', [\App\Http\Controllers\AdminCartController::class, 'refuse'])->name('admin.carts.refuse');
    });
});

Route::get('/', [App\Http\Controllers\MainController::class, 'index']);
Route::post('/services/load-product', [App\Http\Controllers\MainController::class, 'loadProduct']);
Route::get('supplier/list', [SupplierController::class, 'show_index']);


Route::get('danh-muc/{id}-{slug}.html', [App\Http\Controllers\MenuController::class, 'index']);
Route::get('san-pham/{id}-{slug}.html', [App\Http\Controllers\ProductController::class, 'index']);


Route::post('add-cart', [App\Http\Controllers\CartController::class, 'index']);
Route::get('carts', [App\Http\Controllers\CartController::class, 'show']);
Route::post('update-cart', [App\Http\Controllers\CartController::class, 'update']);
Route::get('carts/delete/{id}', [App\Http\Controllers\CartController::class, 'remove']);
Route::post('carts', [App\Http\Controllers\CartController::class, 'addCart']);
Route::post('checkout', [App\Http\Controllers\CartController::class, 'checkout']);

// Route::get('/indexs', 'App\Http\Controllers\StripeController@index')->name('index');
Route::get('/index', 'App\Http\Controllers\StripeController@index')->name('index');
Route::post('/checkout', 'App\Http\Controllers\StripeController@checkout')->name('checkout');
Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');

use App\Http\Controllers\ContactController;

Route::get('/contact', [ContactController::class, 'show']);

Route::post('/contact', [ContactController::class, 'send']);
Route::get('invoice/{id}', 'InvoiceController@generateInvoice');
Route::get('/preview', [InvoiceController::class, 'previewPDF']);
Route::get('/pdf/preview', 'InvoiceController@preview');

Route::get('/pdf/preview/{customerId}', 'InvoiceController@preview')->name('pdf.preview');
Route::get('/pdf/preview/{customerId}', [InvoiceController::class, 'preview'])->name('pdf.preview');

#login-register
use App\Http\Controllers\UserController;

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('check_login', [UserController::class, 'login']);
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/save_register', [UserController::class, 'save_register']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');



#cash
// Route::post('/webhook/paypal', [WebhookController::class, 'handleWebhook']);
// Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
// Route::get('/paypal/checkout', 'PayPalController@createPayment')->name('paypal.checkout');
// Route::get('/paypal/execute', 'PayPalController@executePayment')->name('paypal.execute');
// Route::post('/webhook/paypal', [WebhookController::class, 'handleWebhook']);
Route::post('paypal', [PayPalController::class, 'paypal'])->name('paypal');
Route::post('success_paypal', [PayPalController::class, 'success_paypal'])->name('success_paypal');
Route::post('cancel', [PayPalController::class, 'cancel'])->name('cancel');


#order

Route::get('showOrderStatistics', [MainController::class, 'showOrderStatistics'])->name('showOrderStatistics');
// Route::get('/admin', [MainController::class, 'index']);
// Route::get('/admin/order-statistics', [MainController::class, 'showOrderStatistics']);

#auth
Route::get('/user/profile', [AuthController::class, 'showUserProfile'])->name('user.profile');
// Route::get('/login', 'AuthController@showLoginForm');

#status
use App\Http\Controllers\Admin\CartController;

Route::get('/carts/index', [CartController::class, 'index'])->name('carts.index');
Route::get('/carts/show/{id}', [CartController::class, 'show'])->name('carts.show');
Route::get('/carts/approve/{id}', [CartController::class, 'approve'])->name('carts.approve');
Route::get('/carts/cancel/{id}', [CartController::class, 'cancel'])->name('carts.cancel');



#checkorder
Route::get('/orders', [CartController::class, 'index']);
