<?php

namespace App\Http\Controllers;

use App\Models\BalanceSheets;
use App\Models\LossAndProfits;
use App\Models\CashFlows;
use App\Models\Companies;
use App\Models\Items;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\FinancesImport;
use Maatwebsite\Excel\Facades\Excel;

class ExtractController extends Controller
{
    public function extract(Request $request)
    {
        try {
            // Validate the file input and sheet name
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv'
            ]);

            // COMPANY DATA
            $sheetName = 2;
            $import = new FinancesImport($sheetName);

            Excel::import($import, $request->file('file'));
            
            // GET DATA
            $companyData = $import->sheets()[$sheetName]->rows ?? [];

            $companyName = '';
            $companyCode = '';
            $periodeFinance = '';
            $tahunFinance = '';

            foreach($companyData as $itemData){
                switch($itemData['key']) {
                    case 'Nama entitas':
                        $companyName = $itemData['value'];
                        break;
                    case 'Kode entitas':
                        $companyCode = $itemData['value'];
                        break;
                    case 'Periode penyampaian laporan keuangan':
                        $periodeFinance = $itemData['value'];
                        break;
                    case 'Tanggal awal periode berjalan':
                        $tahunFinance = explode('-', $itemData['value'])[0];
                }
            }
            $periodeMapping = [
                'Kuartal I / First Quarter' => 'Q1',
                'Kuartal II / Second Quarter' => 'Q2',
                'Kuartal III / Third Quarter' => 'Q3',
            ];
            $periodeFinance = $periodeMapping[$periodeFinance] ?? $periodeFinance;

            // CHECK IF COMPANY EXIST
            $companyRecord = Companies::where([
                'CompanyName' => $companyName,
                'CompanyCode' => $companyCode
            ])->first();
            $companyID = $companyRecord->CompanyID ?? '';

            if(!$companyID){
                // INSERT DATA
                $companyInsert = Companies::create([
                    'CompanyName' => $companyName,
                    'CompanyCode' => $companyCode,
                    'Status' => 'Y',
                    'CreateWho' => 'TEST_ADMIN',
                    'ChangeWho' => 'TEST_ADMIN',
                ]);
                $companyID = $companyInsert->id;
            }


            // GET ITEMS
            $itemRecords = Items::where([
                'Status' => 'Y'
            ])->get()->keyBy('ItemName');

            // BALANCE SHEETS
            $this->storeFinancialData(3, BalanceSheets::class, $companyID, $companyName, $companyCode, $itemRecords, $tahunFinance, $periodeFinance, $request);

            // LOSS PROFIT
            $this->storeFinancialData(4, LossAndProfits::class, $companyID, $companyName, $companyCode, $itemRecords, $tahunFinance, $periodeFinance, $request);

            // CASH FLOW
            $this->storeFinancialData(7, CashFlows::class, $companyID, $companyName, $companyCode, $itemRecords, $tahunFinance, 
            $periodeFinance, $request);

            // Return the extracted key-value pairs as JSON
            return response()->json([
                'message' => 'Success'
            ]);   
        } catch (Exception $e) {
            \Log::error('Error extracting data: '.$e->getMessage());
            return response()->json(['message' => 'Error processing', 'error' => $e->getMessage()], 500);
        }
    }

    private function storeFinancialData($sheetName, $modelName, $companyID, $companyName, $companyCode, $itemRecords, $tahunFinance, $periodeFinance, $request)
    {
        $import = new FinancesImport($sheetName);

        Excel::import($import, $request->file('file'));
        
        $sheetData = $import->sheets()[$sheetName]->rows ?? [];
        foreach ($sheetData as $rowData) {
            // GET ITEMS DATA
            if(!$itemRecords->has($rowData['key'])){
                continue;
            }
            $itemData = $itemRecords->get($rowData['key']);

            // GET VALUE
            $sheetRecords = $modelName::where([
                'Status' => 'Y',
                'CompanyID' => $companyID,
                'ItemID' => '1',
                'ItemName' => $rowData['key'],
            ])->first();
            
            if($sheetRecords){
                $valueRecord = $sheetRecords->ItemValue;

                // CHECK YEAR
                if(!isset($valueRecord[$tahunFinance])){
                    $valueRecord[$tahunFinance] = [];
                }
            }else{
                $valueRecord[$tahunFinance] = [];
            }

            $valueRecord[$tahunFinance][$periodeFinance] = $rowData['value'];

            if($sheetRecords){
                $modelName::where([
                    'Status' => 'Y',
                    'CompanyID' => $companyID,
                    'ItemID' => '1' 
                ])->update([
                    'ItemValue' => $valueRecord,
                    'ChangeWho' => 'TEST_ADMIN',
                ]);
            }else{
                $modelName::create([
                    'CompanyID' => $companyID,
                    'CompanyName' => $companyName,
                    'CompanyCode' => $companyCode,
                    'ItemID' => $itemData->ItemID, // TODO : Change to dynamic
                    'ItemName' => $rowData['key'],
                    'ItemValue' => $valueRecord,
                    'ItemParent' => $itemData->ItemParent, // TODO : Change to dynamic
                    'Status' => 'Y',
                    'CreateWho' => 'TEST_ADMIN',
                    'ChangeWho' => 'TEST_ADMIN',
                ]);
            }
        }
    }
}
