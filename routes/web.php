<?php

use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/admin', function () {
//     return view('pages.admin.auth.login');
// });

Route::middleware(['auth','admin'])->group(function () {
    Route::get('home', function(){
        return view('pages.admin.dashboard');
    })->name('home');

    Route::resource('products', ProductController::class);
    Route::resource('categories', ProductCategoryController::class);
    
    Route::resource('user', UserController::class)->only([
      'index', 'store', 'update', 'destroy'
    ])->names('user');
    Route::resource('suppliers', SupplierController::class);
    

    Route::controller(GalleryController::class)->group(function () {
        Route::get('/gallery', 'index');
        Route::post('/gallery/simpan', 'simpan');
    });
});

