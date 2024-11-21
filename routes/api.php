<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtractController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RoleUserController;

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
    return "Server Backend berjalan....";
});

Route::post('extracts', [ExtractController::class, 'extract']);

Route::prefix('finances')->group(function() {
    // GET /finances/balancesheet/{companyID}
    Route::get('balancesheet/{companyID}', [FinanceController::class, 'balanceSheet']);

    // GET /finances/lossandprofit/{companyID}
    Route::get('lossandprofit/{companyID}', [FinanceController::class, 'lossAndProfit']);

    // GET /finances/cashflow/{companyID}
    Route::get('cashflow/{companyID}', [FinanceController::class, 'cashFlow']);
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

Route::prefix('role-users')->group(function() {
    // GET /role-users
    Route::get('', [RoleUserController::class, 'index']);
    
    // GET /role-users
    Route::get('/{id}', [RoleUserController::class, 'show']);
    
    // POST /role-users
    Route::post('', [RoleUserController::class, 'store']);
    
    // PUT /role-users
    Route::put('/{id}', [RoleUserController::class, 'update']);
    
    // DELETE /role-users
    Route::delete('/{id}', [RoleUserController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
