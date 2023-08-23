<?php

use App\Http\Controllers\StripeController;
use Inertia\Inertia;
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
    return Inertia::render('Index');
});
Route::get('/show/{id}', function ($id) {
    return Inertia::render('Show', ['id' => $id]);
});
Route::get('charge-checkout/{boat}', [StripeController::class, 'chargeCheckout']);
