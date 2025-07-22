<?php

namespace App\Http\Controllers;

use App\Models\edges;
use App\Models\nodes;
use App\Helpers\AStar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    //

    public function Beranda(){
        return view('user.DashboardUser');
    }

    public function pangan(){
        return view('user.pangan');
    }

    public function Cuaca(){
        // API key langsung ditulis di sini (bukan dari .env)
        $apiKey = 'e762ceb9eca042e9fe87def18486d804';
        // $city = 'Makassar';
        $latitude = -4.009557527322553;
        $longitude = 122.52050303886116;

        $response = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
            // 'q' => $city,
            'lat' => $latitude,
            'lon' => $longitude,
            'appid' => $apiKey,
            'units' => 'metric'
        ]);

        if ($response->successful()) {
            $data = $response->json();

            $now = Carbon::now();
            $threeDaysLater = $now->copy()->addDays(3);

            $weatherData = collect($data['list'])->filter(function ($item) use ($now, $threeDaysLater) {
                $dt = Carbon::parse($item['dt_txt']);
                return $dt->between($now, $threeDaysLater);
            })->map(function ($item) {
                return [
                    'time' => $item['dt_txt'],
                    'temp' => $item['main']['temp'],
                    'humidity' => $item['main']['humidity'],
                    'wind' => $item['wind']['speed'],
                    'rain' => $item['rain']['3h'] ?? 0,
                    'weather' => $item['weather'][0]['description'],
                ];
            });

            return view('user.Grafikcuaca', [
                'weatherData' => $weatherData
            ]);
        }

        return view('user.Grafikcuaca', ['weatherData' => collect()]);
    }

   


    public function Model(){
        // $edge = edges::all();
        // $node = nodes::all();
        return view('user.modeltrans');
    
    }

    public function Distribusi(){
        return view('user.GrafikDistribusi');
    }


    // public function cariRute(Request $request)
    // {
    //      $start = $request->input('start_node');
    //     $end = $request->input('end_node');

    //     // Ambil graph dari DB (node & edge)
    //     $nodes = nodes::all()->keyBy('name'); // anggap kolom 'name' adalah nama kabupaten
    //     $edges = edges::all();

    //     // Konversi data ke format graph
    //     $graph = [];
    //     foreach ($edges as $edge) {
    //         $from = $edge->from;
    //         $to = $edge->to;
    //         $cost = $edge->cost;

    //         $graph[$from][] = ['to' => $to, 'cost' => $cost];
    //         $graph[$to][] = ['to' => $from, 'cost' => $cost]; // jika undirected
    //     }

    //     // Jalankan algoritma A*
    //     $aStar = new AStar($graph, $nodes);
    //     $path = $aStar->findPath($start, $end); // misal hasil: ['Kolaka', 'Konawe', 'Kendari']

    //     // Ambil koordinat berdasarkan path
    //     $rute = nodes::whereIn('name', $path)
    //         ->orderByRaw("FIELD(name, '" . implode("','", $path) . "')")
    //         ->get(['latitude as lat', 'longitude as lng']);

    //     return view('user.modeltrans', compact('rute'));
    // }

// public function cariRute(Request $request)
// {
//     $start = $request->input('start_node');
//     $end = $request->input('end_node');

//     // Ambil semua node dan edge
//     $nodes = nodes::all()->keyBy('name');
//     $edges = edges::all();

//     // Bangun graph
//     $graph = [];
//     foreach ($edges as $edge) {
//         $graph[$edge->source][] = ['to' => $edge->target, 'cost' => $edge->distance];
//         $graph[$edge->target][] = ['to' => $edge->source, 'cost' => $edge->distance];
//     }

//     // Fungsi bantu: menyambungkan node ke node terdekat jika dia tidak punya tetangga
//     foreach ([$start, $end] as $node) {
//         if (!isset($graph[$node]) || empty($graph[$node])) {
//             $current = $nodes[$node];
//             $minDist = INF;
//             $closestNode = null;

//             foreach ($nodes as $targetId => $target) {
//                 if ($targetId === $node) continue;
//                 if (!isset($graph[$targetId]) || empty($graph[$targetId])) continue; // hindari node terisolasi juga

//                 $dist = $this->haversine(
//                     $current->latitude, $current->longitude,
//                     $target->latitude, $target->longitude
//                 );

//                 if ($dist < $minDist) {
//                     $minDist = $dist;
//                     $closestNode = $targetId;
//                 }
//             }

//             // Jika ketemu, sambungkan dua arah
//             if ($closestNode) {
//                 $graph[$node][] = ['to' => $closestNode, 'cost' => $minDist];
//                 $graph[$closestNode][] = ['to' => $node, 'cost' => $minDist];
//             }
//         }
//     }

//     // Jalankan algoritma A*
//     $start_time = microtime(true);

//     $aStar = new \App\Helpers\AStar($graph, $nodes);
//     $path = $aStar->findPath($start, $end);

//     $end_time = microtime(true);
//     $executionTime = round($end_time - $start_time, 6);

//     if (empty($path)) {
//         return response()->json(['error' => 'Rute tidak ditemukan'], 404);
//     }

//     // Ambil koordinat path
//     $rute = nodes::whereIn('name', $path)
//         ->orderByRaw("FIELD(name, '" . implode("','", $path) . "')")
//         ->get(['latitude as lat', 'longitude as lng']);

//     return response()->json($rute);
// }

// // Fungsi haversine distance (dalam km)
// private function haversine($lat1, $lon1, $lat2, $lon2)
// {
//     $earthRadius = 6371;

//     $dLat = deg2rad($lat2 - $lat1);
//     $dLon = deg2rad($lon2 - $lon1);

//     $lat1 = deg2rad($lat1);
//     $lat2 = deg2rad($lat2);

//     $a = sin($dLat / 2) ** 2 +
//          cos($lat1) * cos($lat2) *
//          sin($dLon / 2) ** 2;

//     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

//     return $earthRadius * $c;
// }


public function cariRute(Request $request)
{
    $start = $request->input('start_node');
    $end = $request->input('end_node');

    // Ambil semua node dan edge
    $nodes = nodes::all()->keyBy('name');
    $edges = edges::all();

    // Bangun graph
    $graph = [];
    foreach ($edges as $edge) {
        $graph[$edge->source][] = ['to' => $edge->target, 'cost' => $edge->distance];
        $graph[$edge->target][] = ['to' => $edge->source, 'cost' => $edge->distance];
    }

    // Sambungkan node terisolasi
    foreach ([$start, $end] as $node) {
        if (!isset($graph[$node]) || empty($graph[$node])) {
            $current = $nodes[$node];
            $minDist = INF;
            $closestNode = null;

            foreach ($nodes as $targetId => $target) {
                if ($targetId === $node) continue;
                if (!isset($graph[$targetId]) || empty($graph[$targetId])) continue;

                $dist = $this->haversine(
                    $current->latitude, $current->longitude,
                    $target->latitude, $target->longitude
                );

                if ($dist < $minDist) {
                    $minDist = $dist;
                    $closestNode = $targetId;
                }
            }

            if ($closestNode) {
                $graph[$node][] = ['to' => $closestNode, 'cost' => $minDist];
                $graph[$closestNode][] = ['to' => $node, 'cost' => $minDist];
            }
        }
    }

    // Jalankan A*
    $start_time = microtime(true);
    $aStar = new \App\Helpers\AStar($graph, $nodes);
    $path = $aStar->findPath($start, $end);
    $end_time = microtime(true);
    $executionTime = round($end_time - $start_time, 6); // detik

    if (empty($path)) {
        return response()->json(['error' => 'Rute tidak ditemukan'], 404);
    }

    // Ambil koordinat rute
    $rute = nodes::whereIn('name', $path)
        ->orderByRaw("FIELD(name, '" . implode("','", $path) . "')")
        ->get(['latitude as lat', 'longitude as lng']);

    // Hitung total jarak dari rute (dari titik ke titik)
    $totalDistance = 0;
    for ($i = 0; $i < count($rute) - 1; $i++) {
        $totalDistance += $this->haversine(
            $rute[$i]->lat, $rute[$i]->lng,
            $rute[$i + 1]->lat, $rute[$i + 1]->lng
        );
    }

    return response()->json([
        'rute' => $rute,
        'totalDistance' => round($totalDistance, 2), // km
        'executionTime' => $executionTime . ' detik',
    ]);
}

private function haversine($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // radius bumi dalam km

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $lat1 = deg2rad($lat1);
    $lat2 = deg2rad($lat2);

    $a = sin($dLat / 2) ** 2 +
         cos($lat1) * cos($lat2) *
         sin($dLon / 2) ** 2;

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c;
}




    
}
