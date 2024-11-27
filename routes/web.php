<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckCart;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\CkeditorFileUploadController;
use App\Models\Product;
use App\Models\Role;

Auth::routes();

Route::post('ckeditor/upload', [CkeditorFileUploadController::class, 'store'])->name('ckeditor.upload');


Route::get('', [HomeController::class, 'index'])->name('home');
Route::get('terms-and-conditions', [PageController::class, 'termsConditions'])
    ->name('terms-conditions');
Route::get('privacy-policy', [PageController::class, 'privacyPolicy'])
    ->name('privacy-policy');
Route::get('shipping-policy', [PageController::class, 'shippingFaqs'])
    ->name('shipping-policy');
Route::get('faqs', [PageController::class, 'faqs'])
    ->name('faqs');
Route::get('shipping-expedition-fee', [PageController::class, 'shippingFee'])
    ->name('shipping-expedition-fee');
Route::get('our-story', [PageController::class, 'ourStory'])
    ->name('our-story');

Route::get('product/{product_slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('shop/{category_slug?}', [ProductController::class, 'shop'])->name('shop.index');

Route::get('shopping-cart', [CartController::class, 'index'])->name('shopping-cart');
Route::post('cart/{item_id}/add', [CartController::class, 'addToCart'])->name('cart.add.item');
Route::post('cart/{row_id}/update', [CartController::class, 'updateCart'])->name('cart.update.item');
Route::post('cart/{row_id}/remove', [CartController::class, 'removeFromCart'])->name('cart.remove.item');
Route::post('cart/clear', [CartController::class, 'clearCart'])->name('cart.remove.all');
Route::post('cart/add/shipping', [CartController::class, 'addShipping'])->name('add.shipping')->middleware([CheckCart::class]);

Route::get('checkout', [CartController::class, 'checkout'])->name('checkout')->middleware([CheckCart::class]);

Route::post('payment/{code}', [PaymentController::class, 'makePayment'])->name('make.payment');

Route::get('payment/{type}/status/{paymentId}', [PaymentController::class, 'checkPaymentStatus'])
    ->name('check.momo.payment');
Route::get('payment/{ref_id}/success', [PaymentController::class, 'successPayment'])
    ->name('payment.success');
Route::post('momo/callback', [NotifyController::class, 'mobileMoney'])
    ->name('api.momo.notify');
Route::post('monetbil/callback', [NotifyController::class, 'monetBilCallback'])
    ->name('api.monetbil.notify');
Route::post('review/{item_id}', [ReviewController::class, 'store'])->name('review.submit');
Route::get('receipt/{ref_id}', [PaymentController::class, 'receipt'])
    ->name('receipt.show');
Route::get('lang/{lang}', [PageController::class, 'setLocale'])->name('locale.set');

Route::get('update-product-text', function () {
    foreach (Product::all() as $product) {
        $product->update([
            'description' => str_replace("<img", "<img loading='lazy'", $product->description),
            'details' => str_replace("<img", "<img loading='lazy'", $product->details),
            'features' => str_replace("<img", "<img loading='lazy'", $product->features),
            'usages' => str_replace("<img", "<img loading='lazy'", $product->usages),
        ]);
    }
});
