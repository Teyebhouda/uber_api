<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UberController;
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


Route::get('/uber/auth', [UberController::class, 'redirectToUberAuth'])->name('uber.auth');
Route::get('/uber/callback', [UberController::class, 'handleUberCallback'])->name('uber.callback');
Route::get('/uber/profile', [UberController::class, 'fetchDriverProfile'])->name('uber.profile');
Route::get('/uber/trips', [UberController::class, 'fetchDriverTrips'])->name('uber.trips');
Route::get('/uber/payments', [UberController::class, 'fetchDriverPayments'])->name('uber.payments');