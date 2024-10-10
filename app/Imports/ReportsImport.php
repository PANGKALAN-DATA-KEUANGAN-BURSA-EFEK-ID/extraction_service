<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsImport implements ToCollection, WithStartRow, WithMapping
{
    public $rows;

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

        \Log::info("Final collected rows: ", $this->rows); // Log the final result
    }
}