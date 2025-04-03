<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\RegisterController;
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

// Route::get('/', function () {
//     return view('welcome');
// });




Route::group(['middleware' => 'Userauth'], function () {
    Route::get('/', [FrontController::class, 'home'])->name('home');
    Route::get('/register', [RegisterController::class, 'register'])->name('account.register');
    Route::post('/processregistation', [RegisterController::class, 'processregistation'])->name('processregistation');
    Route::get('/login', [RegisterController::class, 'login'])->name('login');
    Route::post('/authenticate', [RegisterController::class, 'authetication'])->name('authetication');
});

Route::group(['middleware' => 'User'], function () {
    Route::get('/profile', [RegisterController::class, 'profile'])->name('account.profile');
    Route::get('/logout', [RegisterController::class, 'logout'])->name('account.logout');

});
