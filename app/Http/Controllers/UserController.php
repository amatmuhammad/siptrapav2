<?php

namespace App\Http\Controllers;

// use DB;
use App\Models\edges;
use App\Models\nodes;
use App\Models\pangan;
use App\Helpers\MinHeap;
use App\Models\kabupaten;
use App\Models\namaPangan;
use App\Models\produsen;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //

    public function Beranda(){
        $data = kabupaten::count();
        $produsen = produsen::count();
        $nama_pangan = namaPangan::count();

        return view('user.DashboardUser', compact('data','produsen','nama_pangan'));
    }

    //function pangan -> grafik pangan
    public function pangan(Request $request){
        $nama_pangan = namaPangan::all();

        $bulanList = pangan::selectRaw("DATE_FORMAT(tanggal_pengiriman, '%Y-%m') as bulan")
                        ->distinct()
                        ->orderBy('bulan', 'desc')
                        ->pluck('bulan');

        $filter_pangan = $request->input('nama_pangan_id');
        // $filter_bulan = $request->input('bulan') ?? now()->format('Y-m');
        $filter_bulan = $request->input('bulan') ?? ($bulanList->first() ?? now()->format('Y-m'));

        $query = Pangan::join('tbl_kabupaten as k', 'tbl_pangan.tujuan_pangan', '=', 'k.id')
            ->select('k.nama_kabupaten', DB::raw('SUM(tbl_pangan.volume) as total_volume'))
            ->groupBy('k.nama_kabupaten');

        if ($filter_pangan) {
            $query->where('tbl_pangan.nama_pangan_id', $filter_pangan);
        }

        if ($filter_bulan) {
            $query->whereRaw("DATE_FORMAT(tanggal_pengiriman, '%Y-%m') = ?", [$filter_bulan]);
        }

        $data = $query->get();

        // Cek jika request-nya AJAX, kembalikan data JSON saja
        if ($request->ajax()) {
            return response()->json($data);
        }

        return view('user.pangan', compact('data', 'filter_pangan', 'filter_bulan', 'nama_pangan', 'bulanList'));
    }

    //function distribusi -> grafik distribusi
    public function Distribusi(){
        $dataDistribusi = pangan::with(['asalKabupaten', 'tujuanKabupaten', 'namaPangan'])->get();
        return view('user.GrafikDistribusi', compact('dataDistribusi'));
    }
    
    //modeltrans
    public function Model(){
        
        $node = nodes::where(function($query) {
            $query->where('name', 'LIKE', '%Kota%')
                    ->orWhere('name', 'LIKE', '%Kabupaten%');
        })->orderBy('name','desc')->get();

        // dd($node);

        return view('user.modeltrans',compact('node'));
    }

    public function RefreshGraph()
    {
        Cache::forget('graph_coords');
        Cache::forget('graph_edges');

        return redirect()->route('Node')->with('success', 'Graph cache berhasil di-refresh!');
    }


    //function cuaca -> grafik cuaca
    // public function Cuaca(Request $request)
    // {
    //     $kabupaten = kabupaten::all();

    //     if (!$request->has('kabupaten')) {
    //         return view('user.Grafikcuaca', ['weatherData' => collect(), 'kabupaten' => $kabupaten]);
    //     }

    //     // Pecah latitude dan longitude dari string "lat,lon"
    //     [$latitude, $longitude] = explode(',', $request->kabupaten);

    //     // API key langsung ditulis di sini (bukan dari .env)
    //     $apiKey = 'e762ceb9eca042e9fe87def18486d804';

    //     $response = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
    //         // 'q' => $city,
    //         'lat' => $latitude,
    //         'lon' => $longitude,
    //         'appid' => $apiKey,
    //         'units' => 'metric'
    //     ]);

    //     if ($response->successful()) {
    //         $data = $response->json();

    //         $now = Carbon::now();
    //         $threeDaysLater = $now->copy()->addDays(3);

    //         $weatherData = collect($data['list'])->filter(function ($item) use ($now, $threeDaysLater) {
    //             $dt = Carbon::parse($item['dt_txt']);
    //             return $dt->between($now, $threeDaysLater);
    //         })->map(function ($item) {
    //             return [
    //                 'time' => $item['dt_txt'],
    //                 'temp' => $item['main']['temp'],
    //                 'humidity' => $item['main']['humidity'],
    //                 'wind' => $item['wind']['speed'],
    //                 'rain' => $item['rain']['3h'] ?? 0,
    //                 'weather' => $item['weather'][0]['description'],
    //             ];
    //         });

    //         return view('user.Grafikcuaca', [
    //             'weatherData' => $weatherData
    //         ]);
    //     }

    //     return view('user.Grafikcuaca', ['weatherData' => collect(), 'kabupaten' => $kabupaten]);
    // }

    public function Cuaca(Request $request)
    {
        $kabupaten = kabupaten::all();

        if (!$request->has('kabupaten')) {
            // Saat halaman dibuka pertama kali, belum ada kabupaten dipilih
            return view('user.Grafikcuaca', [
                'weatherData' => collect(),
                'kabupaten' => $kabupaten
            ]);
        }

        [$latitude, $longitude] = explode(',', $request->kabupaten);

        $apiKey = 'e762ceb9eca042e9fe87def18486d804';

        $response = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
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
                'weatherData' => $weatherData,
                'kabupaten' => $kabupaten
            ]);
        }

        // Jika API gagal
        return view('user.Grafikcuaca', [
            'weatherData' => collect(),
            'kabupaten' => $kabupaten
        ]);
    }



    //bidirectional a star with a star alternatif
    public function cariRute(Request $request)
    {
        $jenisPangan = $request->input('jenis_pangan');
        $volume = $request->input('volume');
        // $cuaca = $this->cekCuacaJikaBuah($jenisPangan);
        $cuaca = $this->cekCuacaJikaBuah($request->end_node);


        if ($cuaca) {
            $alertLevel = 'success'; // default: cuaca baik
            $alertMessage = 'Cuaca baik dan aman untuk distribusi.';

            if ($cuaca['rain'] > 5 || $cuaca['wind'] > 8) {
                $alertLevel = 'danger';
                $alertMessage = 'Cuaca buruk! Distribusi sebaiknya ditunda karena hujan lebat atau angin kencang.';
            } elseif ($cuaca['rain'] > 2 || $cuaca['wind'] > 5) {
                $alertLevel = 'warning';
                $alertMessage = 'Cuaca kurang baik. Harap berhati-hati saat distribusi.';
            }
        }

        $node = nodes::where(function($query) {
            $query->where('name', 'LIKE', '%Kota%')
                    ->orWhere('name', 'LIKE', '%Kabupaten%');
        })->orderBy('name','desc')->get();

        $start = microtime(true);

        $source = $request->start_node;
        $target = $request->end_node;

        $nodes = Cache::rememberForever('graph_coords', function () {
            return nodes::all()->keyBy('name')->map(fn($n) => [
                'lat' => $n->latitude,
                'lng' => $n->longitude,
            ])->toArray();
        });

        $originalGraph = Cache::rememberForever('graph_edges', function () {
            $edges = edges::all();
            $g = [];
            foreach ($edges as $e) {
                $g[$e->source][] = ['to' => $e->target, 'cost' => $e->distance];
                $g[$e->target][] = ['to' => $e->source, 'cost' => $e->distance];
            }
            return $g;
        });

        if (!isset($nodes[$source]) || !isset($nodes[$target])) {
            return back()->with('error', 'Node tidak ditemukan.');
        }

        // --- 1. Rute Utama ---
        [$fullPath, $totalDistance] = $this->bidirectionalAStar($source, $target, $nodes, $originalGraph);
        $ruteUtama = $this->formatCoords($fullPath, $nodes);

        // --- 2. Modifikasi Edge Cost untuk Alternatif ---
        $penalizedGraph = $originalGraph;
        for ($i = 0; $i < count($fullPath) - 1; $i++) {
            $a = $fullPath[$i];
            $b = $fullPath[$i + 1];
            foreach ($penalizedGraph[$a] as &$edge) {
                if ($edge['to'] === $b) {
                    $edge['cost'] *= 2; // Penalti
                }
            }
            foreach ($penalizedGraph[$b] as &$edge) {
                if ($edge['to'] === $a) {
                    $edge['cost'] *= 2; // Penalti
                }
            }
        }

        // --- 3. Jalankan kembali Bidirectional A* untuk Alternatif ---
        [$altPath, $altDistance] = $this->bidirectionalAStar($source, $target, $nodes, $penalizedGraph);
        $ruteAlternatif = $this->formatCoords($altPath, $nodes);

        $kecepatanKmh = 60;

        $waktuTempuhJam = $totalDistance / $kecepatanKmh;
        $waktuTempuhAlternatifJam = $altDistance / $kecepatanKmh;

        $waktuTempuhUtama = [
            'jam' => floor($waktuTempuhJam),
            'menit' => round(($waktuTempuhJam - floor($waktuTempuhJam)) * 60)
        ];

        $waktuTempuhAlternatif = [
            'jam' => floor($waktuTempuhAlternatifJam),
            'menit' => round(($waktuTempuhAlternatifJam - floor($waktuTempuhAlternatifJam)) * 60)
        ];

        $biayaUtama = $this->hitungBiayaDistribusi($totalDistance);
        $biayaAlternatif = $this->hitungBiayaDistribusi($altDistance);


        $executionTime = microtime(true) - $start;

        dd("starnode : ".$source, "endnode : ".$target);

        return view('user.modeltrans', [
            'rute' => $ruteUtama ?? [],
            'jalur_alternatif' => $ruteAlternatif ?? [],
            'distance_km' => isset($totalDistance) ? round($totalDistance, 2) : null,
            'distance_alt_km' => isset($altDistance) ? round($altDistance, 2) : null,
            'execution_time' => $executionTime ?? null,
            'start_node' => $source ?? null,
            'end_node' => $target ?? null,
            'jenis_pangan' => $jenisPangan ?? null,
            'volume' => $volume ?? null,
            'cuaca' => $cuaca ?? null,
            'alert_level' => $alertLevel ?? null,
            'alert_message' => $alertMessage ?? null,
            'node' => $node ?? null,
            'waktu_tempuh' => $waktuTempuhUtama ?? null,
            'waktu_tempuh_alt' => $waktuTempuhAlternatif ?? null,
            'biaya_utama' => $biayaUtama ?? null,
            'biaya_alternatif' => $biayaAlternatif ?? null,

        ]);

    }

    private function hitungBiayaDistribusi($jarakKm)
    {
        if ($jarakKm <= 5) {
            return 10000;
        } elseif ($jarakKm <= 20) {
            return 10000 + ($jarakKm - 5) * 5000;
        } else {
            return 10000 + (15 * 5000) + ($jarakKm - 20) * 10000;
        }
    }


    private function approxDistance($a, $b)
    {
        $dx = $a['lat'] - $b['lat'];
        $dy = $a['lng'] - $b['lng'];
        return sqrt($dx * $dx + $dy * $dy);
    }


    // Function pemanggil bidirectional A* (reusable)
    private function bidirectionalAStar($source, $target, $nodes, $graph)
    {
        $openF = new MinHeap(); $openB = new MinHeap();
        $gF = []; $gB = [];
        $cameFromF = []; $cameFromB = [];
        $visitedF = []; $visitedB = [];

        $gF[$source] = 0; $gB[$target] = 0;
        $openF->insert($source, 0); $openB->insert($target, 0);
        $meetingNode = null;

        while (!$openF->isEmpty() && !$openB->isEmpty()) {
            $currentF = $openF->extract();
            $visitedF[$currentF] = true;

            if (isset($visitedB[$currentF])) {
                $meetingNode = $currentF;
                break;
            }

            foreach ($graph[$currentF] ?? [] as $neighbor) {
                $tentative = $gF[$currentF] + $neighbor['cost'];
                if (!isset($gF[$neighbor['to']]) || $tentative < $gF[$neighbor['to']]) {
                    $gF[$neighbor['to']] = $tentative;
                    $cameFromF[$neighbor['to']] = $currentF;
                    $h = $this->approxDistance($nodes[$neighbor['to']], $nodes[$target]);
                    $openF->insert($neighbor['to'], $tentative + $h);
                }
            }

            $currentB = $openB->extract();
            $visitedB[$currentB] = true;

            if (isset($visitedF[$currentB])) {
                $meetingNode = $currentB;
                break;
            }

            foreach ($graph[$currentB] ?? [] as $neighbor) {
                $tentative = $gB[$currentB] + $neighbor['cost'];
                if (!isset($gB[$neighbor['to']]) || $tentative < $gB[$neighbor['to']]) {
                    $gB[$neighbor['to']] = $tentative;
                    $cameFromB[$neighbor['to']] = $currentB;
                    $h = $this->approxDistance($nodes[$neighbor['to']], $nodes[$source]);
                    $openB->insert($neighbor['to'], $tentative + $h);
                }
            }
        }

        if (!$meetingNode) return [[], 0];

        $pathF = [$meetingNode];
        while (isset($cameFromF[$pathF[0]])) array_unshift($pathF, $cameFromF[$pathF[0]]);
        $pathB = [];
        $node = $meetingNode;
        while (isset($cameFromB[$node])) {
            $node = $cameFromB[$node];
            $pathB[] = $node;
        }

        $fullPath = array_merge($pathF, $pathB);
        $totalDistance = 0;
        for ($i = 0; $i < count($fullPath) - 1; $i++) {
            $totalDistance += $this->approxDistance($nodes[$fullPath[$i]], $nodes[$fullPath[$i + 1]]) * 111.32;
        }

        return [$fullPath, $totalDistance];
    }

    private function formatCoords($path, $nodes)
    {
        $coords = [];
        foreach ($path as $node) {
            if (isset($nodes[$node])) {
                $coords[] = ['lat' => $nodes[$node]['lat'], 'lng' => $nodes[$node]['lng']];
            }
        }
        return $coords;
    }

    private function cekCuacaJikaBuah($endNode)
    {
        $node = nodes::where('name', $endNode)->first();
        if (!$node) {
            return null;
        }

        $apiKey = 'e762ceb9eca042e9fe87def18486d804';
        $latitude = $node->latitude;
        $longitude = $node->longitude;

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat'   => $latitude,
            'lon'   => $longitude,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang'  => 'id'
        ]);

        if ($response->successful()) {
            $data = $response->json();

            return [
                'description' => $data['weather'][0]['description'],
                'temperature' => $data['main']['temp'],
                'humidity' => $data['main']['humidity'],
                'wind' => $data['wind']['speed'],
                'rain' => $data['rain']['3h'] ?? 0,
                'timestamp' => Carbon::now('Asia/Makassar')->format('H:i d/m/Y'),
            ];
        }

        return null;
    }
    //end

    public function clearRute(Request $request)
    {
        Session::forget(['start', 'end', 'rute', 'jalur_alternatif']);
        return response()->json([
            'message' => 'Session cleared',
            'redirect' => route('Model') // Ini akan dikirim ke JS untuk redirect
        ]);
    }

    



















    




}
