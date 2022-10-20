<?php

use App\Http\Controllers\Base\CreditCardController;
use App\Http\Controllers\Base\FileController;
use App\Http\Controllers\Base\PaymentController;
use App\Http\Controllers\Base\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('files', FileController::class);
    Route::resource('payments', PaymentController::class);
    Route::post('/credit-card/payments', [CreditCardController::class, 'index'])->name('credit_card.payments');
});

require __DIR__ . '/auth.php';
