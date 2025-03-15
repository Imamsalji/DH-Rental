<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\paymentController;
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

Route::prefix('')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// Rute yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {

    Route::get('/list', [paymentController::class, 'listRental'])->name('list');


    Route::get('/history', [paymentController::class, 'history'])->name('history');
    Route::get('/reservasi', [paymentController::class, 'reservasi'])->name('reservasi');
    Route::get('/booking', [paymentController::class, 'booking'])->name('booking');

    Route::get('/halPayment/{id}', [paymentController::class, 'halPayment'])->name('halPayment');
    Route::post('/payment/{id}', [paymentController::class, 'paymentStore'])->name('payment');
    Route::get('/halPayout/{token}', [paymentController::class, 'halTransaksi'])->name('halPayout');
    Route::get('/simulasi/{token}', [paymentController::class, 'simulasi'])->name('simulasi');
});
