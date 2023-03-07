
<?php

use Illuminate\Support\Facades\Route;

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

// Web Routes
Route::get('/',[App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
Route::get('/shop',[App\Http\Controllers\Web\HomeController::class, 'shop'])->name('shop');
Route::get('/product/{slug}',[App\Http\Controllers\Web\HomeController::class, 'product'])->name('product');
Route::get('/cart',[App\Http\Controllers\Web\HomeController::class, 'cart'])->name('cart');
Route::get('/checkout',[App\Http\Controllers\Web\HomeController::class, 'checkout'])->name('checkout');
Route::get('/about-us',[App\Http\Controllers\Web\HomeController::class, 'about_us'])->name('about-us');
Route::get('/contact-us',[App\Http\Controllers\Web\HomeController::class, 'contact_us'])->name('contact-us');
Route::get('/privacy-policy',[App\Http\Controllers\Web\HomeController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('/terms-and-conditions',[App\Http\Controllers\Web\HomeController::class, 'terms_and_conditions'])->name('terms-and-conditions');
Route::post('actions',[App\Http\Controllers\Web\ActionController::class, 'actions']);
// Auth Routes

Route::get('login',[App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::get('logout',[App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::post('login',[App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::get('/my-account',[App\Http\Controllers\Web\HomeController::class, 'my_account'])->name('my-account');
Route::get('/wishlist',[App\Http\Controllers\Web\HomeController::class, 'wishlist'])->name('wishlist');
Route::group(['middleware'=>['auth']],function(){

});

//Admin Routes
Route::group(['prefix'=>'admin','middleware'=>['auth','admin']],function(){
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::get('/categories/{id}/delete_image', [App\Http\Controllers\Admin\CategoryController::class, 'destroyImage']);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::get('/products/{id}/delete_image', [App\Http\Controllers\Admin\ProductController::class, 'destroyImage']);
});
