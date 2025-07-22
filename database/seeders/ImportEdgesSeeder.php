<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;

class ImportEdgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nodesPath = base_path('database/seeders/edge_baru.xlsx');
        $data = Excel::toArray(new class implements ToArray {
            public function array(array $array)
            {
                return $array;
            }
        }, $nodesPath);

        $batchSize = 5000;
        $nodes = [];
        $totalNodes = 0;

        foreach ($data[0] as $key => $row) {
            if ($key === 0) continue; // Lewati header
            if (count($row) >= 3) { //ubah menjadi 4 ketika node bertipe
                $nodes[] = [
                    'source' => $row[0],
                    'target' => $row[1],
                    'distance' => $row[2],
                    
                    // 'tipe' => $row[3], // Ambil nilai tipe dari kolom Excel
                ];
                $totalNodes++;

                if (count($nodes) >= $batchSize) {
                    DB::table('edges')->insert($nodes);
                    $nodes = [];
                }
            }
        }

        if (count($nodes) > 0) {
            DB::table('edges')->insert($nodes);
        }

        echo "Total nodes inserted: " . $totalNodes . "\n";
    }
}
