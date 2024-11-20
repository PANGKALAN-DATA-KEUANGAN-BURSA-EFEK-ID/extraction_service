<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtractController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\CompanyController;

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

Route::get('/', function(){
    return "Live Server!!";
});

Route::post('extracts', [ExtractController::class, 'extract']);

Route::prefix('finances')->group(function() {
    // GET /finances/balancesheet/{companyID}
    Route::get('balancesheet/{companyID}', [FinanceController::class, 'balanceSheet']);

    // GET /finances/lossandprofit/{companyID}
    Route::get('lossandprofit/{companyID}', [FinanceController::class, 'lossAndProfit']);

    // GET /finances/cashflow/{companyID}
    Route::get('cashflow/{companyID}', [FinanceController::class, 'cashFlows']);
});

Route::prefix('companies')->group(function() {
    // GET /companies
    Route::get('', [CompanyController::class, 'index']);
    
    // GET /companies
    Route::get('/{id}', [CompanyController::class, 'show']);
    
    // POST /companies
    Route::post('', [CompanyController::class, 'store']);
    
    // PUT /companies
    Route::put('/{id}', [CompanyController::class, 'update']);
    
    // DELETE /companies
    Route::delete('/{id}', [CompanyController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
