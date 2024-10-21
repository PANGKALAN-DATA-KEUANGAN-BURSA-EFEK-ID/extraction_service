<?php

namespace App\Imports;

use App\Models\BalanceSheets;
use App\Models\LossAndProfits;
use App\Models\CashFlows;
use App\Models\Companies;
use App\Models\Items;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMapping;

class FinancesImport implements ToCollection, WithStartRow, WithMapping, WithMultipleSheets
{
    private $sheetName;
    public $rows;

    // Constructor to pass the sheet name
    public function __construct($sheetName)
    {
        $this->sheetName = $sheetName;
    }

    public function sheets(): array
    {
        return [
            $this->sheetName => $this,
        ];
    }

    // Specify where to start reading data (skip the header row)
    public function startRow(): int
    {
        return 6; // Start reading from row 2
    }

    // Map each row to a key-value pair from specific columns (A as key, B as value)
    public function map($row): array
    {
        \Log::info('Row data being mapped:', $row);

        return [
            'key' => $row[0],  
            'value' => $row[1],
        ];
    }

    // Collect the mapped rows
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (isset($row['key'])) {
                // LOG THE ITERATION
                \Log::info("Collected rows: ".$row); 

                // SEARCH
                // INSERT TO DATABASE
                // BalanceSheets
                if($this->sheetName == '3'){
                    BalanceSheets::create([
                        'CompanyID' => '1',
                        'CompanyName' => 'Prasanna',
                        'CompanyCode' => 'MPRASN',
                        'ItemID' => '1',
                        'ItemName' => $row['key'],
                        'ItemValue' => $row['value'],
                        'ItemParent' => 'test',
                        'Status' => 'Y',
                        'CreateWho' => 'TEST_ADMIN',
                        'ChangeWho' => 'TEST_ADMIN',
                    ]);
                }
                // LossAndProfits
                else if ($this->sheetName == '4'){
                    LossAndProfits::create([
                        'CompanyID' => '1',
                        'CompanyName' => 'Prasanna',
                        'CompanyCode' => 'MPRASN',
                        'ItemID' => '1',
                        'ItemName' => $row['key'],
                        'ItemValue' => $row['value'],
                        'ItemParent' => 'test',
                        'Status' => 'Y',
                        'CreateWho' => 'TEST_ADMIN',
                        'ChangeWho' => 'TEST_ADMIN',
                    ]);
                }
                // CashFlows
                else if ($this->sheetName == '7'){
                    CashFlows::create([
                        'CompanyID' => '1',
                        'CompanyName' => 'Prasanna',
                        'CompanyCode' => 'MPRASN',
                        'ItemID' => '1',
                        'ItemName' => $row['key'],
                        'ItemValue' => $row['value'],
                        'ItemParent' => 'test',
                        'Status' => 'Y',
                        'CreateWho' => 'TEST_ADMIN',
                        'ChangeWho' => 'TEST_ADMIN',
                    ]);
                }

                // SAVE THE ROW
                $this->rows[] = $row;
            }
        }

        // LOG THE FINAL RESULT
        \Log::info("Final collected rows: ", $this->rows); 
    }
}
