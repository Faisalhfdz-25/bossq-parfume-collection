<?php

use App\Http\Controllers\BarangMasukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KonfirmasiBelanjaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ListBelanjaController;

use App\Http\Controllers\ProductCategoryController;


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
    
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');

        
    Route::controller(GalleryController::class)->group(function () {
        Route::get('/gallery', 'index');
        Route::post('/gallery/simpan', 'simpan');
    });

    Route::controller(ListBelanjaController::class)->group(function () {
        Route::get('/list-belanja', 'index');
        Route::post('/list-belanja/simpan', 'simpan');
        Route::post('/list-belanja/ajukan', 'ajukan');
    });

    Route::controller(KonfirmasiBelanjaController::class)->group(function () {
        Route::get('/konfirmasi-belanja', 'index');
        Route::get('/konfirmasi-belanja/detail/{id}', 'getDetails');
        Route::post('/konfirmasi-belanja/ubah-status', 'update');
        Route::get('/konfirmasi-belanja/print/{kode}', 'print');
        Route::get('/konfirmasi-belanja/print-pdf/{kode}', 'printPdf');
    });
    
    Route::controller(BarangMasukController::class)->group(function () {
        Route::get('/barang-masuk', 'index');
        Route::post('/barang-masuk/simpan', 'simpan');
    });
});

