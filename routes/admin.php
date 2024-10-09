<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShippingAgencyController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserAddressController;
use App\Http\Controllers\Admin\UserController;

Auth::routes();

Route::group(['middleware' => 'guest'],
    function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot_password');
    });

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/account-settings', [AuthController::class, 'accountSetting'])->name('account_setting');
    Route::patch('/account-settings', [AuthController::class, 'updateAccount'])->name('account_setting.update');
    Route::get('/categories/{category}/remove-image', [CategoryController::class, 'removeImage'])->name('categories.remove_image');
    Route::resource('categories', CategoryController::class);
    Route::post('/products/remove-image', [ProductController::class, 'removeImage'])->name('products.remove_image');
    Route::resource('products', ProductController::class);
    Route::resource('tags', TagController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('reviews', ReviewController::class);
    Route::get('/supervisors/{supervisor}/remove-image', [SupervisorController::class, 'removeImage'])->name('supervisors.remove_image');
    Route::resource('supervisors', SupervisorController::class);
    Route::resource('countries', CountryController::class);
    Route::get('/states/get-states', [StateController::class, 'get_states'])->name('states.get_states');
    Route::resource('states', StateController::class);
    Route::get('/cities/get-cities', [CityController::class, 'get_cities'])->name('cities.get_cities');
    Route::resource('cities', CityController::class);
    Route::get('users/get-users', [UserController::class, 'get_users'])->name('users.get_users');
    Route::resource('users', UserController::class);
    Route::resource('user_addresses', UserAddressController::class);
    Route::resource('shipping_agencies', ShippingAgencyController::class);
    Route::resource('payment_methods', PaymentMethodController::class);
    Route::get('orders/export', [OrderController::class, 'export'])->name('orders.export');
    Route::resource('orders', OrderController::class)->except('create', 'edit');
    Route::resource('settings', SettingController::class)->only('index', 'update');
    Route::resource('links', LinkController::class)->except('show');
    Route::resource('pages', PageController::class);

});
