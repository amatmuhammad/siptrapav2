<?php

namespace App\Imports;

use App\Models\nodes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class Nodesimport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $batch = [];

        foreach ($rows as $row) {
            $batch[] = [
                'name'      => $row['name'],
                'latitude'  => $row['latitude'],
                'longitude' => $row['longitude'],
                'category'  => $row['category'],
                'roadname'  => $row['roadname'] ?? null
            ];
        }

        DB::table('nodes')->insert($batch);
    }


    public function chunkSize(): int
    {
        return 5000;
    }

    public function batchSize(): int
    {
        return 5000;
    }
}
