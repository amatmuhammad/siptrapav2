@extends('layouts.main')

@section('judul', 'Data Kabupaten')

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

    #map {
      height: 350px;
      width: 100%;
    }

</style>

<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card">
              <h3 class="card-header"><b>Data Kabupaten</b><hr style="border: 2px solid rgb(225, 225, 225);"></h3>
                <div class="card-body">
                    <div class="row justify-content-between mb-5">
                      <div class="col d-flex align-items-center mb-3 mb-md-0">
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
                        <div class="col-md-4 mb-3 mb-md-0 text-md-end">
                          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                           + Tambah Data
                          </button>
                        </div>
                        
                    </div>
                  <div class="table-responsive ">
                    <table class="table table-bordered table-striped table-hover">
                      <thead class="table-warning">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Kabupaten</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      
                      <tbody class="text-center">
                      @forelse ($strapa as $item)
                        <tr>
                            <td>{{ $strapa->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nama_kabupaten }}</td>
                            <td>{{ $item->latitude }}</td>
                            <td>{{ $item->longitude }}</td>
                            <td>
                                @if($item->gambar)
                                    <img src="{{ asset('images/' . $item->gambar) }}" width="100" alt="Gambar">
                                @else
                                    Tidak ada gambar
                                @endif
                            </td>
                          <td>
                             <div>
                                <button class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#editKabupatenModal{{ $item->id }}"><i class="icon-base bx bx-edit-alt me-1"></i></button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}"> <i class="icon-base bx bx-trash me-1"></i></button>
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
                      <span class="text-muted">Total Data Kabupaten : {{ $strapa->total() }} Data</span>

                        <nav>
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
                        </nav>

                  </div> 
                </div>
              </div>
        </div>
    </div>
</div>


<!-- Modal Create Kabupaten -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('createKabupaten') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kabupaten</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Kabupaten</label>
            <input type="text" name="nama_kabupaten" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
          </div>

          <div class="mb-3">
            <label>Pilih Lokasi di Peta</label>
            <div id="map" style="height: 350px;"></div>
          </div>

          <div class="row">
            <div class="col">
              <label>Latitude</label>
              <input type="text" id="latitude" name="latitude" class="form-control" readonly required>
            </div>
            <div class="col">
              <label>Longitude</label>
              <input type="text" id="longitude" name="longitude" class="form-control" readonly required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>


@foreach($strapa as $item)
<div class="modal fade" id="editKabupatenModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('updateKabupaten', $item->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Kabupaten - {{ $item->nama_kabupaten }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Kabupaten</label>
            <input type="text" name="nama_kabupaten" class="form-control" value="{{ $item->nama_kabupaten }}" required>
          </div>

          <div class="mb-3">
            <label>Gambar</label><br>
            @if($item->gambar)
              <img src="{{ asset('images/' . $item->gambar) }}" alt="Gambar Kabupaten" width="120" class="mb-2"><br>
            @endif
            <input type="file" name="gambar" class="form-control">
          </div>

          <div class="mb-3">
            <label>Pilih Lokasi di Peta</label>
            <div id="map{{ $item->id }}" style="height: 350px;"></div>
          </div>

          <div class="row">
            <div class="col">
              <label>Latitude</label>
              <input type="text" id="latitude{{ $item->id }}" name="latitude" class="form-control" value="{{ $item->latitude }}" readonly required>
            </div>
            <div class="col">
              <label>Longitude</label>
              <input type="text" id="longitude{{ $item->id }}" name="longitude" class="form-control" value="{{ $item->longitude }}" readonly required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info">Perbarui</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach


@foreach ($strapa as $item)
    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('destroyKabupaten', $item->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Konfirmasi Hapus</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              Apakah Anda yakin ingin menghapus data Nama Kabupaten = <strong>{{ $item->nama_kabupaten }}</strong> Beserta Relasinya ?
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">Hapus</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
@endforeach


{{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}

<script>
  document.addEventListener("DOMContentLoaded", function () {
      const map = L.map('map').setView([-4.0, 122.0], 7); // sesuaikan pusat peta
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      let marker;

      map.on('click', function(e) {
          const { lat, lng } = e.latlng;
          document.getElementById('latitude').value = lat;
          document.getElementById('longitude').value = lng;

          if (marker) {
              marker.setLatLng(e.latlng);
          } else {
              marker = L.marker(e.latlng).addTo(map);
          }
      });

      // Optional: reset marker on modal show
      $('#exampleModal').on('shown.bs.modal', function () {
          map.invalidateSize();
      });
  });

  // Peta untuk setiap modal edit
      document.addEventListener("DOMContentLoaded", function () {

    @foreach($strapa as $item)
        let map{{ $item->id }};
        let marker{{ $item->id }};

        $('#editKabupatenModal{{ $item->id }}').on('shown.bs.modal', function () {
            // Cek jika map belum dibuat, lalu buat
            if (!map{{ $item->id }}) {
                map{{ $item->id }} = L.map('map{{ $item->id }}').setView([{{ $item->latitude }}, {{ $item->longitude }}], 8);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 18
                }).addTo(map{{ $item->id }});

                marker{{ $item->id }} = L.marker([{{ $item->latitude }}, {{ $item->longitude }}], {
                    draggable: true
                }).addTo(map{{ $item->id }});

                marker{{ $item->id }}.on('dragend', function (e) {
                    const latlng = e.target.getLatLng();
                    document.getElementById('latitude{{ $item->id }}').value = latlng.lat.toFixed(6);
                    document.getElementById('longitude{{ $item->id }}').value = latlng.lng.toFixed(6);
                });
            }

            // Force redraw agar map muncul sempurna
            setTimeout(() => {
                map{{ $item->id }}.invalidateSize();
            }, 300);
        });
    @endforeach

});
</script>


@endsection