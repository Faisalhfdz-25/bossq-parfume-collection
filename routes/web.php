<?php

use App\Http\Controllers\LandingPagesController;
use App\Models\LandingPages;
use Illuminate\Support\Facades\Route;

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
});

Route::prefix('landing_pages')->group(function () {
    Route::get('/', [LandingPagesController::class, 'index'])->name('landing_pages.index');
    Route::get('/create',[LandingPagesController::class, 'create'])->name('landing_pages.create');
    Route::post('/', [LandingPagesController::class, 'store'])->name('landing_pages.store');
    Route::get('/{id}/edit', [LandingPagesController::class, 'edit'])->name('landing_pages.edit');
    Route::put('/{id}', [LandingPagesController::class, 'update'])->name('landing_pages.update');
    Route::delete('/{id}',[LandingPagesController::class, 'destroy'])->name('landing_pages.destroy');
});