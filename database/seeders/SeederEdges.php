<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeederEdges extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::disableQueryLog();

        $filePath = base_path('database/seeders/Edges.xlsx');

        $rows = Excel::toCollection(null, $filePath)[0]; // Ambil sheet pertama

        $batchSize = 1000;
        $batch = [];
        $totalInserted = 0;

        foreach ($rows as $index => $row) {
            // Lewati header jika Excel tidak otomatis parse
            if ($index === 0 && strtolower($row[0]) === 'source') {
                continue;
            }

            if (count($row) < 3) continue;

            $batch[] = [
                'source'      => $row[0],
                'target'      => $row[1],
                'distance'    => (float)$row[2],
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            if (count($batch) >= $batchSize) {
                DB::table('edges')->insert($batch);
                $totalInserted += count($batch);
                echo "Inserted: $totalInserted rows...\n";
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('edges')->insert($batch);
            $totalInserted += count($batch);
            echo "Inserted (final): $totalInserted rows\n";
        }

        echo "✅ Import dari Excel selesai. Total baris: $totalInserted\n";
    }
}
