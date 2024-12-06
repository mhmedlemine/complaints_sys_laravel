<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckupController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\EntrepriseController;
use App\Models\Checkup;
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
    Route::get('getEntrepriseCode', [EntrepriseController::class, 'getEntrepriseCode']);
    Route::get('entreprises/type/{type}', [EntrepriseController::class, 'getByType']);
    Route::apiResource('checkups', CheckupController::class);
    Route::get('my-checkups', [CheckupController::class, 'myCheckups']);
    Route::get('my-summons', [CheckupController::class, 'mySummons']);
    Route::post('addCheckup', [CheckupController::class, 'store']);
    Route::post('/checkups/start', [CheckupController::class, 'start']);
    Route::post('/checkups/{checkup}/progress', [CheckupController::class, 'saveProgress']);
    Route::post('/checkups/{checkup}/submit', [CheckupController::class, 'submit']);
    Route::post('/checkups/{checkup}/cancel', [CheckupController::class, 'cancel']);
    Route::post('/complaints/submit', [CheckupController::class, 'submitComplaint']);
    Route::get('getClosestShop', [CheckupController::class, 'getClosestShop']);
    Route::get('getInfractions', [CheckupController::class, 'getInfractions']);
    Route::get('complaints/consumers/search', [CheckupController::class, 'searchConsumer']);
    Route::post('addConsumer', [CheckupController::class, 'addConsumer']);
});
