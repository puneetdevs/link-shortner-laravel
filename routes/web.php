<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlController;
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


#HOME
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    #URL

    Route::get('/dashboard', [UrlController::class, 'showDashboard'])->middleware(['verified'])->name('dashboard');
    
    Route::post('/store', [UrlController::class, 'storeUrl'])->name('url.store');

    #PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/{slug}', [UrlController::class, 'redirectToDest'])->where('slug', '[a-zA-Z0-9-]+')->name('url.redirect');

