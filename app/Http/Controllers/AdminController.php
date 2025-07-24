<?php

namespace App\Http\Controllers;

use App\Models\edges;
use App\Models\nodes;
use App\Models\pangan;
use App\Models\produsen;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function dashboard(){
        return view('admin.Dashboard');

    }


    public function persebaran(){
        return view('admin.persebaran');

    }

    public function Node(request $request){

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
    $query = nodes::orderBy('created_at', 'desc');

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


    public function Edge(Request $request){
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
    $query = edges::orderBy('created_at', 'desc');

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

    public function dataPangan(){
        
    }

    public function ViewLogin(){
        return view('admin.Login');
    }

    public function ViewRegister(){
        return view('admin.Register');
    }

    public function produsen(){

        $strapa = produsen::all();

        return view('admin.produsen', compact('strapa'));
    }

    public function panganadmin(){
        $strapa = pangan::all();

        return view('admin.pangan', compact('strapa'));
    }
}
