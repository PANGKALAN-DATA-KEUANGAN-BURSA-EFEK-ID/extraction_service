<?php

namespace App\Http\Controllers;

use App\Models\BalanceSheets;
use App\Models\LossAndProfits;
use App\Models\CashFlows;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FinanceController extends Controller
{
    // GET /finance/balancesheet/{companyID} 
    public function balanceSheet($companyID)
    {
        $balanceSheet = BalanceSheets::where([
            'Status' => 'Y',
            'CompanyID' => $companyID
        ])->get();

        if($balanceSheet->isEmpty()){
            return response()->json(['message' => 'Balance Sheet is not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($balanceSheet, Response::HTTP_OK);
    }
    
    // GET /finance/lossandprofit/{companyID} 
    public function lossAndProfit($companyID)
    {
        $lossAndProfit = LossAndProfits::where([
            'Status' => 'Y',
            'CompanyID' => $companyID
        ])->get();

        if($lossAndProfit->isEmpty()){
            return response()->json(['message' => 'Loss and Profit is not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($lossAndProfit, Response::HTTP_OK);
    }

    // GET /finance/cashflow/{companyID} 
    public function cashFlow($companyID)
    {
        $cashFlow = CashFlows::where([
            'Status' => 'Y',
            'CompanyID' => $companyID
        ])->get();

        if($cashFlow->isEmpty()){
            return response()->json(['message' => 'Cash Flow is not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($cashFlow, Response::HTTP_OK);
    }
}
