@extends('layouts.main')

@section('judul','Data Produsen')

@section('konten')

<style>
    /* Menghilangkan efek bulat di tombol pagination Bootstrap */
    .pagination .page-link {
        border-radius: 4px !important; /* Bikin agak kotak, bukan oval */
        padding: 6px 12px; /* Atur padding biar proporsional */
    }

    .pagination .page-item.active .page-link {
        background-color: #e27900; /* Warna biru (indigo) */
        border-color: #e27900;
        hover: 
        color: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); /* Optional: efek shadow */
    }

    .pagination .page-link:hover {
        background-color: #e27900; /* Orange lebih terang */
        border-color: #e27900;
        color: white;
    }

</style>

<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card">
              <h3 class="card-header"><b>Data Produsen/Distributor</b><hr style="border: 2px solid rgb(225, 225, 225);"></h3>
                <div class="card-body">
                    <div class="row justify-content-between">
                      <div class="col">
                        <span class="me-1">Show Data</span>
                        <form method="GET" action="{{ route('Node') }}">
                                  <select name="show_entries" class="form-control" onchange="this.form.submit()" style="width: auto;">
                                      <option value="10" {{ request()->get('show_entries') == 10 ? 'selected' : '' }}>10</option>
                                      <option value="25" {{ request()->get('show_entries') == 25 ? 'selected' : '' }}>25</option>
                                      <option value="50" {{ request()->get('show_entries') == 50 ? 'selected' : '' }}>50</option>
                                      <option value="100" {{ request()->get('show_entries') == 100 ? 'selected' : '' }}>100</option>
                                  </select>
                                </form>
                        </div>
                        <div class="col-md-4 mb-5">
                          <form action="{{ route('Node') }}" method="GET" >
                            <label for="Search">Cari Produsen/Distributor</label>
                            <input type="text" class="form-control" name="search" id="search" placeholder="Cari Data Node..." value="{{ request()->get('search', session('search_node')) }}" />
                          </form>
                        </div>
                        
                    </div>
                  <div class="table-responsive ">
                    <table class="table table-bordered table-striped">
                      <thead class="table-warning">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Distributor</th>
                            <th>Nama Pemilik</th>
                            <th>No HP</th>
                            <th>Jenis Pangan</th>
                            <th>Jenis Distributor</th>
                            <th>Asal (Kabupaten)</th>
                            <th>Tujuan Distribusi (Kabupaten)</th>
                            <th>Alamat</th>
                            <th>Wilayah Cakupan</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      
                      <tbody class="text-center">
                      @forelse ($strapa as $item)
                        <tr>
                            <td>{{ $item->nama_distributor }}</td>
                            <td>{{ $item->nama_pemilik }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->jenis_pangan }}</td>
                            <td>{{ $item->jenis_distributor }}</td>
                            <td>{{ $item->asal }}</td>
                            <td>{{ $item->tujuan_distribusi }}</td>
                            <td>{{ $item->alamat_distributor }}</td>
                            <td>{{ $item->wilayah_cakupan }}</td>
                            <td>{{ $item->latitude }}, {{ $item->longitude }}</td>
                          <td>
                             <div>
                                <button class="btn btn-warning"><i class="icon-base bx bx-edit-alt me-1"></i></button>
                                <button class="btn btn-danger"> <i class="icon-base bx bx-trash me-1"></i></button>
                            </div>                              
                          </td>
                        </tr>
                      @empty
                      <tr>
                        <td colspan="11">
                          
                          Tidak ada data yang bisa ditampilkan
                        </td>
                      </tr>
                        
                      @endforelse
                        
                       
                      </tbody>
                    </table>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                      {{-- <span class="text-muted">Total Data Node : {{ $strapa->total() }} Data</span> --}}

                        {{-- <nav>
                            <ul class="pagination justify-content-center pagination-md mt-3">
                                
                                @if ($strapa->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $strapa->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif

                               
                                <li class="page-item active">
                                    <span class="page-link">{{ $strapa->currentPage() }}</span>
                                </li>

                                
                                @if ($strapa->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $strapa->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                                @endif
                            </ul>
                        </nav> --}}

                  </div> 
                </div>
              </div>
        </div>
    </div>
</div>


@endsection