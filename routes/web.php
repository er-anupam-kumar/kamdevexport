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

//Auth Routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('login',[App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::get('logout',[App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::post('login',[App\Http\Controllers\Auth\LoginController::class, 'login']);

//Admin Routes
Route::group(['prefix'=>'admin','middleware'=>['auth','admin']],function(){
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::get('/categories/{id}/delete_image', [App\Http\Controllers\Admin\CategoryController::class, 'destroyImage']);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::get('/products/{id}/delete_image', [App\Http\Controllers\Admin\ProductController::class, 'destroyImage']);
});
