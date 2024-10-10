<?php

namespace App\Imports;

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
        // \Log::info('Row data being mapped:', $row);

        return [
            'key' => $row[0],  // Column A (description)
            'value' => $row[1], // Column B (value)
        ];
    }

    // Collect the mapped rows
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (isset($row['key'])) {
                // \Log::info("Collected rows: ".$row); // Log the final result
                $this->rows[] = $row;
            }
        }

        // \Log::info("Final collected rows: ", $this->rows); // Log the final result
    }
}