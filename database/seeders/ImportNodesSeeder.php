<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;

class ImportNodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $nodesPath = base_path('database/seeders/nodes_with_ferry_route_new.xlsx');
        // Excel::import(new Nodesimport, $nodesPath);
        // echo "Import selesai.\n";


        $nodesPath = base_path('database/seeders/node_baru.xlsx');
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
            if (count($row) >= 5) { //ubah menjadi 4 ketika node bertipe
                $nodes[] = [
                    'name' => $row[0],
                    'latitude' => $row[1],
                    'longitude' => $row[2],
                    'category' => $row[3],
                    'roadname' => $row[4] ?? null,
                    // 'tipe' => $row[3], // Ambil nilai tipe dari kolom Excel
                ];
                $totalNodes++;

                if (count($nodes) >= $batchSize) {
                    DB::table('nodes')->insert($nodes);
                    $nodes = [];
                }
            }
        }

        if (count($nodes) > 0) {
            DB::table('nodes')->insert($nodes);
        }

        echo "Total nodes inserted: " . $totalNodes . "\n";
    }
}
