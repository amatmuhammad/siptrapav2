@extends('layouts.main')

@section('judul','Data Node')

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
              <h3 class="card-header"><b>Data Node</b><hr style="border: 2px solid rgb(225, 225, 225);"></h3>
                <div class="card-body">
                    {{-- <div class="row justify-content-between">
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
                                <form action="{{ route('Node') }}" method="GET" >
                                  <label for="Search">Cari Node</label>
                                  <input type="text" class="form-control" name="search" id="search" placeholder="Cari Data Node..." value="{{ request()->get('search', session('search_node')) }}" />
                                </form>
                        </div>
                        <div class="col-md-4 mb-5">
                          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNodeModal">
                              Tambah Node
                          </button>

                        </div>
                        
                    </div> --}}
{{-- justify-content-between --}}
                    {{-- <div class="row  align-items-end mb-5">
                      <!-- Show Entries + Search -->
                      <div class="col-md-7">
                          <form method="GET" action="{{ route('Node') }}" class="d-flex align-items-center flex-wrap gap-2">
                              <!-- Show Entries -->
                              <label for="show_entries" class="me-2">Show : </label>
                              <select name="show_entries" id="show_entries" class="form-control w-auto me-2" onchange="this.form.submit()">
                                  <option value="10" {{ request()->get('show_entries') == 10 ? 'selected' : '' }}>10</option>
                                  <option value="25" {{ request()->get('show_entries') == 25 ? 'selected' : '' }}>25</option>
                                  <option value="50" {{ request()->get('show_entries') == 50 ? 'selected' : '' }}>50</option>
                                  <option value="100" {{ request()->get('show_entries') == 100 ? 'selected' : '' }}>100</option>
                              </select>
                              <span class="me-2">Cari : </span>

                              <!-- Search -->
                              <input type="text" name="search" class="form-control w-auto me-2" placeholder="Cari Node..." value="{{ request()->get('search', session('search_node')) }}">
                              <button type="submit" class="btn btn-info">Cari</button>
                          </form>
                      </div>

                      <!-- Tombol Tambah Node -->
                      <div class="col-2 ">
                        <div class="button-tambah">
                          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNodeModal">
                              + Node
                          </button>
                        </div>
                      </div>
                  </div> --}}

                  <div class="row align-items-end mb-5">
                      <!-- Show Entries + Search -->
                      <div class="col-md-7">
                          <form method="GET" action="{{ route('Node') }}" class="d-flex align-items-center flex-wrap gap-2">
                              <!-- Show Entries -->
                              <label for="show_entries" class="me-2">Show : </label>
                              <select name="show_entries" id="show_entries" class="form-control w-auto me-2" onchange="this.form.submit()">
                                  <option value="10" {{ request()->get('show_entries') == 10 ? 'selected' : '' }}>10</option>
                                  <option value="25" {{ request()->get('show_entries') == 25 ? 'selected' : '' }}>25</option>
                                  <option value="50" {{ request()->get('show_entries') == 50 ? 'selected' : '' }}>50</option>
                                  <option value="100" {{ request()->get('show_entries') == 100 ? 'selected' : '' }}>100</option>
                              </select>
                              <span class="me-2">Cari : </span>

                              <!-- Search -->
                              <input type="text" name="search" class="form-control w-auto me-2" placeholder="Cari Node..." value="{{ request()->get('search', session('search_node')) }}">
                              <button type="submit" class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i></button>
                          </form>
                      </div>

                      <!-- Tombol Tambah Node + Refresh Cache -->
                      <div class="col-md-5 d-flex justify-content-end gap-2">
                           <!-- Tombol Tambah Node -->
                          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNodeModal">
                              <i class="fa-solid fa-circle-plus me-2"></i>Tambah Node
                          </button>

                          <!-- Tombol Refresh Cache -->
                          <!-- Tombol Refresh Cache (Buka Modal) -->
                          <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#refreshCacheModal">
                              <i class="fas fa-repeat me-1"></i> Refresh Cache
                          </button>
                          <!-- Modal Konfirmasi Refresh Cache -->
                          <div class="modal fade" id="refreshCacheModal" tabindex="-1" aria-labelledby="refreshCacheModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="margin-top: 150px;">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="refreshCacheModalLabel"><i class="fas fa-exclamation-triangle me-2 text-danger"></i>Konfirmasi Refresh Cache</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah anda telah menambahkan data node terbaru? Jika <strong>Ya </strong>Silahkan <strong>me-refresh cache graph.</strong>
                                  <strong>Proses ini melakuan percepatan pemuatan rute di halaman Home.</strong><br> Jika tidak pencarian rute tidak akan dilakukan .
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                  <form action="{{ route('RefreshGraph') }}" method="POST">
                                      @csrf
                                      <button type="submit" class="btn btn-warning">Ya, Refresh Sekarang</button>
                                  </form>

                                </div>
                              </div>
                            </div>
                          </div>


                          
                      </div>
                  </div>



                  <div class="table-responsive ">
                    <table class="table table-bordered table-striped">
                      <thead class="table-warning">
                        <tr class="text-center">
                          <th>No</th>
                          <th>Name Node</th>
                          <th>Latitude</th>
                          <th>Longitude</th>
                          <th>Nama Jalan</th>
                          {{-- <th>Actions</th> --}}
                        </tr>
                      </thead>
                      
                      <tbody class="text-center">
                      @forelse ($strapa as $item)
                        <tr>
                          <td>
                            {{ $strapa->firstItem() + $loop->index }}
                          </td>
                          <td>{{ $item->name }}</td>
                          <td>
                            {{$item->latitude}}
                          </td>
                          <td>{{ $item->longitude }}</td>
                          <td>{{ $item->roadname }}</td>
                          {{-- <td> --}}
                            
                             {{-- <div> --}}
                                {{-- <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal{{ $item->id }}"><i class="icon-base bx bx-edit-alt me-1"></i></button> --}}
                                {{-- <button class="btn btn-danger"> <i class="icon-base bx bx-trash me-1"></i></button> --}}
                            {{-- </div>                               --}}
                          {{-- </td> --}}
                        </tr>
                      @empty
                      <tr>
                        <td colspan="7">
                          
                          Tidak ada data yang bisa ditampilkan
                        </td>
                      </tr>
                        
                      @endforelse
                        
                       
                      </tbody>
                    </table>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                      <span class="text-muted">Total Data Node : {{ $strapa->total() }} Data</span>

                      <nav>
                            <ul class="pagination justify-content-center pagination-md mt-3">
                                {{-- Tombol Previous --}}
                                @if ($strapa->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $strapa->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif

                                {{-- Halaman Aktif --}}
                                <li class="page-item active">
                                    <span class="page-link">{{ $strapa->currentPage() }}</span>
                                </li>

                                {{-- Tombol Next --}}
                                @if ($strapa->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $strapa->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                                @endif
                            </ul>
                        </nav>

                  </div> 
                </div>
              </div>
        </div>
    </div>
</div>


<!-- Modal Tambah Node -->
<div class="modal fade" id="addNodeModal" tabindex="-1" aria-labelledby="addNodeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('storeNode') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addNodeModalLabel">Tambah Node Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nama Node</label>
            <input type="text" name="name" class="form-control" id="name" required>
          </div>

         <div class="mb-3">
            <label>Pilih Lokasi di Peta</label>
            <div id="map" style="height: 350px;"></div>
          </div>

          <div class="row">
            <div class="col">
              <label>Latitude</label>
              {{-- <input type="number" id="latitude" name="latitude" class="form-control" readonly required> --}}
              <input type="number" id="latitude" name="latitude" class="form-control" step="any" readonly required>
            </div>
            <div class="col">
              <label>Longitude</label>
              {{-- <input type="number" id="longitude" name="longitude" class="form-control" readonly required> --}}
              <input type="number" id="longitude" name="longitude" class="form-control" step="any" readonly required>
            </div>
          </div>

          <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="category" value="(otomatis atau default)" disabled>
          </div>

          <div class="mb-3">
            <label for="roadname" class="form-label">Nama Jalan</label>
            <input type="text" class="form-control" id="roadname" value="(otomatis atau kosong)" disabled>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan Node</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([-4.0, 122.0], 7);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      let marker;

      map.on('click', function(e) {
          const lat = e.latlng.lat.toFixed(6);
          const lng = e.latlng.lng.toFixed(6);
          document.getElementById('latitude').value = lat;
          document.getElementById('longitude').value = lng;

          if (marker) {
              marker.setLatLng(e.latlng);
          } else {
              marker = L.marker(e.latlng).addTo(map);
          }
      });

      $('#addNodeModal').on('shown.bs.modal', function () {
          map.invalidateSize();
      });

      $('#addNodeModal').on('hidden.bs.modal', function () {
          document.getElementById('latitude').value = '';
          document.getElementById('longitude').value = '';
          if (marker) {
              map.removeLayer(marker);
              marker = null;
          }
      });
  });
</script>



@endsection