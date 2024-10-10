<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\FinancesImport;
use Maatwebsite\Excel\Facades\Excel;

class ExtractController extends Controller
{
    public function extract(Request $request)
    {
        // Validate the file input and sheet name
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // BALANCE SHEETS
        // Get the sheet name (or index) dynamically
        $sheetName = 3; 

        // Initialize the import class with the sheet name
        $import = new FinancesImport($sheetName);

        // Perform the import
        Excel::import($import, $request->file('file'));

        // Get the extracted data from the specific sheet
        $balanceSheet = $import->sheets()[$sheetName]->rows ?? [];

        // LOSS PROFIT
        // Get the sheet name (or index) dynamically
        $sheetName = 4; 

        // Initialize the import class with the sheet name
        $import = new FinancesImport($sheetName);

        // Perform the import
        Excel::import($import, $request->file('file'));

        // Get the extracted data from the specific sheet
        $lossProfit = $import->sheets()[$sheetName]->rows ?? [];

        // CASH FLOW
        // Get the sheet name (or index) dynamically
        $sheetName = 7; 

        // Initialize the import class with the sheet name
        $import = new FinancesImport($sheetName);

        // Perform the import
        Excel::import($import, $request->file('file'));

        // Get the extracted data from the specific sheet
        $cashFlow = $import->sheets()[$sheetName]->rows ?? [];

        // Return the extracted key-value pairs as JSON
        return response()->json([
            'data' => [
                'balanceSheet' => $balanceSheet,
                'lossProfit' => $lossProfit,
                'cashFlow' => $cashFlow,
            ]
        ]);
    }
}