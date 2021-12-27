<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/registrate', [App\Http\Controllers\MainController::class, 'registrate'])->name('registrate');

Route::post('/login', [App\Http\Controllers\MainController::class, 'login'])->name('login');

Route::post('/getOrders', [App\Http\Controllers\MainController::class, 'getOrders'])->name('getOrders');

Route::get('/GetUser', [App\Http\Controllers\MainController::class, 'getUser'])->name('getUser');

Route::post('/cancelOrder', [App\Http\Controllers\MainController::class, 'cancelOrder'])->name('cancelOrder');

Route::post('/logout', [App\Http\Controllers\MainController::class, 'logout'])->name('logout');

Route::get('/getCleanersInfo', [App\Http\Controllers\MainController::class, 'getCleanersInfo'])->name('getCleanersInfo');

Route::post('/cleaningDays', [App\Http\Controllers\MainController::class, 'cleaningDays'])->name('cleaningDays');

Route::get('/additionalServices', [App\Http\Controllers\MainController::class, 'additionalServices'])->name('additionalServices');

Route::put('/makeOrder', [App\Http\Controllers\MainController::class, 'makeOrder'])->name('makeOrder');

Route::post('/getCleanerOrders', [App\Http\Controllers\MainController::class, 'getCleanerOrders'])->name('getCleanerOrders');

Route::delete('/deleteActiveOrder', [App\Http\Controllers\MainController::class, 'deleteActiveOrder'])->name('deleteActiveOrder');

Route::put('/addActiveReview', [App\Http\Controllers\MainController::class, 'addActiveReview'])->name('addActiveReview');

Route::get('/getUserReviews', [App\Http\Controllers\MainController::class, 'getUserReviews'])->name('getUserReviews');

Route::post('/makeReview', [App\Http\Controllers\MainController::class, 'makeReview'])->name('makeReview');

Route::put('/redactReview', [App\Http\Controllers\MainController::class, 'redactReview'])->name('redactReview');

Route::post('/getCleanerReviews', [App\Http\Controllers\MainController::class, 'getCleanerReviews'])->name('getCleanerReviews');

Route::get('/getAllCleaners', [App\Http\Controllers\MainController::class, 'getAllCleaners'])->name('getAllCleaners');

Route::post('/deleteCleanerAccount', [App\Http\Controllers\MainController::class, 'deleteCleanerAccount'])->name('deleteCleanerAccount');

Route::post('/registrateCleaner', [App\Http\Controllers\MainController::class, 'registrateCleaner'])->name('registrateCleaner');

Route::post('/updateService', [App\Http\Controllers\MainController::class, 'updateService'])->name('updateService');

Route::post('/deleteService', [App\Http\Controllers\MainController::class, 'deleteService'])->name('deleteService');

Route::post('/addService', [App\Http\Controllers\MainController::class, 'addService'])->name('addService');

Route::post('/searchReviews', [App\Http\Controllers\MainController::class, 'searchReviews'])->name('searchReviews');