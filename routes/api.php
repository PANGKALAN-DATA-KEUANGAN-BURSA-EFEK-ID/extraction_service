<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtractController;
use App\Http\Controllers\FinanceController;

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


Route::post('extracts', [ExtractController::class, 'extract']);

Route::prefix('finances')->group(function() {
    // GET /finances/balancesheet/{companyID}
    Route::get('balancesheet/{companyID}', [FinanceController::class, 'balanceSheet']);

    // GET /finances/lossandprofit/{companyID}
    Route::get('lossandprofit/{companyID}', [FinanceController::class, 'lossAndProfit']);

    // GET /finances/cashflow/{companyID}
    Route::get('cashflow/{companyID}', [FinanceController::class, 'cashFlows']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
