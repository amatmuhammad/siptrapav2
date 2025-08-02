<?php

namespace App\Http\Controllers;


use App\Models\edges;
use App\Models\nodes;
use App\Models\pangan;
use App\Models\produsen;
use App\Models\kabupaten;
use App\Models\namaPangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //

    //dashboard
    public function dashboard(Request $request)
    {
        $nama_pangan = namaPangan::all();

        $bulanList = pangan::selectRaw("DATE_FORMAT(tanggal_pengiriman, '%Y-%m') as bulan")
                        ->distinct()
                        ->orderBy('bulan', 'desc')
                        ->pluck('bulan');

        $filter_pangan = $request->input('nama_pangan_id');
        $filter_bulan = $request->input('bulan') ?? now()->format('Y-m');

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

        // Jika bukan AJAX, tampilkan view
        return view('admin.Dashboard', compact('data', 'filter_pangan', 'filter_bulan', 'nama_pangan', 'bulanList'));
    }



    public function persebaran()
    {
        $dataDistribusi = pangan::with(['asalKabupaten', 'tujuanKabupaten', 'namaPangan'])->get();
        return view('admin.persebaran', compact('dataDistribusi'));

    }

    public function Node(request $request)
    {
        // Ambil nilai dari request
        $search = $request->get('search');
        $showEntries = $request->get('show_entries', 10);

        // Jika pencarian dikirim, simpan ke session
        if ($request->has('search')) {
            session(['search_node' => $search]);
        } elseif ($request->has('show_entries')) {
            // Kalau hanya mengganti show_entries, pakai search dari session
            $search = session('search_node');
        } else {
            // Reset session kalau tidak ada search maupun show_entries
            session()->forget('search_node');
        }

        // Query dasar
        $query = nodes::orderBy('created_at', 'asc');

        // Tambahkan filter pencarian kalau ada
        if (!empty($search)) {
            $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('latitude','LIKE', '%'. $search . '%')
            ->orWhere('longitude','LIKE', '%'. $search . '%')
            ->orWhere('roadname','LIKE', '%'. $search . '%');
        }

        // Ambil data sesuai show_entries
        $strapa = $query->paginate($showEntries)->appends([
            'show_entries' => $showEntries,
            'search' => $search
        ]);

        return view('admin.Node', compact('strapa', 'showEntries', 'search'));
    }

    public function updateNode(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'category' => 'nullable|string',
            'roadname' => 'nullable|string',
        ]);

        $node = nodes::findOrFail($id);
        $node->update($request->all());

        return redirect()->route('Node')->with('success', 'Data Node Berhasil di Update');
    }


    public function Edge(Request $request)
    {
        // Ambil nilai dari request
        $search = $request->get('search');
        $showEntries = $request->get('show_entries', 10);

        // Jika pencarian dikirim, simpan ke session
        if ($request->has('search')) {
            session(['search_edge' => $search]);
        } elseif ($request->has('show_entries')) {
            // Kalau hanya mengganti show_entries, pakai search dari session
            $search = session('search_edge');
        } else {
            // Reset session kalau tidak ada search maupun show_entries
            session()->forget('search_edge');
        }

        // Query dasar
        $query = edges::orderBy('created_at', 'asc');

        // Tambahkan filter pencarian kalau ada
        if (!empty($search)) {
            $query->where('source', 'LIKE', '%' . $search . '%');
        }

        // Ambil data sesuai show_entries
        $strapa = $query->paginate($showEntries)->appends([
            'show_entries' => $showEntries,
            'search' => $search
        ]);

        return view('admin.edge', compact('strapa', 'showEntries', 'search'));

    }

    public function updateEdge(Request $request, $id)
    {
        $request->validate([
            'source' => 'required|exists:nodes,name',
            'target' => 'required|exists:nodes,name',
            // 'distance' => 'required|numeric|min:0', // tidak divalidasi
        ]);

        $edge = edges::findOrFail($id);
        $edge->update([
            'source' => $request->source,
            'target' => $request->target,
            // 'distance' => $request->distance, // tidak diubah
        ]);

        return redirect()->back()->with('success', 'Data edge berhasil diperbarui.');
    }


    public function login(){
        return view('admin.Login');
    }

    public function ViewRegister(){
        return view('admin.Register');
    }

    public function produsen(Request $request)
    {
        // $strapa = produsen::with('asalKabupaten')->paginate(10);
        $showEntries = $request->get('show_entries', 10);
        $kabupaten = kabupaten::all();
        $pangan = namaPangan::all();
        $Jenis = ['Produsen', 'Petani', 'Pengepul', 'Pabrik'];

        // Ambil data sesuai show_entries
        $strapa = produsen::with('asalKabupaten')->paginate($showEntries)->appends([
            'show_entries' => $showEntries,
        ]);

        return view('admin.produsen', compact('strapa','kabupaten','pangan', 'Jenis'));
    }

    public function storeprodusen(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'nama_distributor' => 'required',
            'no_hp' => 'required',
            'nama_pemilik' => 'required',
            'jenis_pangan' => 'required',
            'jenis_distributor' => 'required',
            'asal' => 'required|exists:tbl_kabupaten,id',
        ]);

        produsen::create($request->all());
        return redirect()->route('produsen')->with('success', 'Distributor berhasil ditambahkan.');
    }

    public function updateprodusen(Request $request, $id)
    {
        $request->validate([
            'nama_distributor' => 'required',
            'no_hp' => 'required',
            'nama_pemilik' => 'required',
            'jenis_pangan' => 'required',
            'jenis_distributor' => 'required',
            'asal' => 'required|exists:tbl_kabupaten,id',
        ]);

        $distributor = produsen::findOrFail($id);
        $distributor->update($request->all());

        return redirect()->route('produsen')->with('success', 'Data distributor berhasil diperbarui.');
    }

    public function destroyprodusen($id)
    {
        $distributor = produsen::findOrFail($id);
        $distributor->delete();

        return redirect()->route('produsen')->with('success', 'Data distributor berhasil dihapus.');
    }

    public function panganadmin(){

        $strapa = pangan::with(['namaPangan', 'asalKabupaten', 'produsen', 'tujuanKabupaten'])->paginate(10);
        $namaPangan = namaPangan::all();
        $kabupaten = kabupaten::all();
        $produsen = produsen::all();

        // dd($nama_pangan);

        // dd($strapa);

        return view('admin.pangan', compact('strapa','namaPangan','kabupaten', 'produsen'));
    }

    public function storepangan(Request $request)
    {
        $request->validate([
            'produsen_id' => 'required',
            'nama_pangan_id' => 'required',
            'volume' => 'required|numeric',
            'nama_pangan_id' => 'required',
            'asal_pangan' => 'required',
            'tujuan_pangan' => 'required',
            'tanggal_pengiriman' => 'required|date',
            'estimasi_kadaluarsa' => 'required|date',
        ]);

        // dd($request->all());

        pangan::create($request->all());

        return redirect()->back()->with('success', 'Data pangan berhasil ditambahkan');
    }



    public function updatepangan(Request $request, $id)
    {
        try {
            // Validasi data
            $request->validate([
                'produsen_id'           => 'required|exists:tbl_produsen_distributor,id',
                'nama_pangan_id'        => 'required|exists:tbl_nama_pangan,id',
                'volume'                => 'required|numeric',
                'asal_pangan'           => 'required|exists:tbl_kabupaten,id',
                'tujuan_pangan'         => 'required|exists:tbl_kabupaten,id',
                'tanggal_pengiriman'    => 'required|date',
                'estimasi_kadaluarsa'   => 'required|date|after_or_equal:tanggal_pengiriman',
            ]);

            // Ambil data
            $pangan = pangan::findOrFail($id);

            // Update data
            $pangan->update($request->all());

            return redirect()->back()->with('success', 'Data pangan berhasil diperbarui');
        } catch (ValidationException $e) {
            // Jika validasi gagal, kirim kembali dengan pesan error
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali isian Anda.');
        } catch (\Exception $e) {
            // Jika ada error lain
            // Log::error('Gagal update data pangan: '.$e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: '.$e->getMessage());
        }
    }


    public function destroypangan($id)
    {
        $pangan = pangan::findOrFail($id);
        $pangan->delete();

        return redirect()->back()->with('success', 'Data pangan berhasil dihapus');
    }

    public function kabupaten(){
        $strapa = kabupaten::paginate(10);

        return view('admin.kabupaten', compact('strapa'));
    }

    public function createKabupaten(Request $request){

        $request->validate([
            'nama_kabupaten' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('images'), $imageName); // simpan ke folder base_path/images
            $data['gambar'] = $imageName;
        }

        Kabupaten::create($data);

        return redirect()->route('kabupaten')->with('success', 'Data Kabupaten berhasil ditambahkan');
        // return view('admin.kabupaten');
    }

    public function updateKabupaten(Request $request, $id){

        $request->validate([
            'nama_kabupaten' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kabupaten = kabupaten::findOrFail($id);

        // Update data teks
        $kabupaten->nama_kabupaten = $request->nama_kabupaten;
        $kabupaten->latitude = $request->latitude;
        $kabupaten->longitude = $request->longitude;

        // Cek apakah ada gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            $oldPath = base_path('images/' . $kabupaten->gambar);
            if ($kabupaten->gambar && File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // Simpan gambar baru
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(base_path('images'), $gambarName);

            // Simpan nama gambar ke database
            $kabupaten->gambar = $gambarName;
        }

        $kabupaten->save();
        
        return redirect()->route('kabupaten')->with('success', 'Data Kabupaten Berhasil Di Update');
        // return view('admin.kabupaten');
    }

    public function destroyKabupaten($id){
        $kabupaten = kabupaten::findOrFail($id);

        // Hapus gambar dari direktori images jika ada
        if ($kabupaten->gambar) {
            $gambarPath = base_path('images/' . $kabupaten->gambar);
            if (File::exists($gambarPath)) {
                File::delete($gambarPath);
            }
        }

        $kabupaten->delete();
        
        return redirect()->route('kabupaten')->with('success', 'Data Kabupaten Berhasil Di hapus');
    }

    public function namaPangan(){
        $strapa = namaPangan::paginate(10);

        return view('admin.namaPangan', compact('strapa'));
    }

    public function createNamaPangan(Request $request){

        $request->validate([
            'nama_pangan' => 'required|string',
        ]);

        namaPangan::create($request->all());
        return redirect()->route('namaPangan')->with('success', 'Nama Pangan berhasil ditambahkan');
        // return view('admin.kabupaten');
    }

    public function updateNamaPangan(Request $request, $id){

        // dd($request);
         $request->validate([
            'nama_pangan' => 'required|string',
        ]);

        $namaPangan = namaPangan::findOrFail($id);
        $namaPangan->update($request->all());
        return redirect()->route('namaPangan')->with('success', 'Nama Pangan Berhasil Di Update');
        // return view('admin.kabupaten');
    }

    public function destroyNamaPangan($id){
        $namaPangan = namaPangan::findOrFail($id);
        $namaPangan->delete();
        return redirect()->route('namaPangan')->with('success', 'Nama Pangan Berhasil Di hapus');
    }

    

}
