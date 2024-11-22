<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\EntrepriseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('complaints', ComplaintController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('entreprises', EntrepriseController::class);
    Route::post('addEntreprise', [EntrepriseController::class, 'store']);
    Route::post('addMerchant', [EntrepriseController::class, 'storeMerchant']);
    Route::get('entreprises/search', [EntrepriseController::class, 'search']);
    Route::get('entreprises/merchants/search', [EntrepriseController::class, 'searchMerchant']);
    Route::get('my-entreprises', [EntrepriseController::class, 'myEntreprises']);
    Route::get('getMoughataas', [EntrepriseController::class, 'getMoughataas']);
    Route::get('entreprises/type/{type}', [EntrepriseController::class, 'getByType']);
});
