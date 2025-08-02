@extends('layouts.main')

@section('judul', 'Data Pangan Admin')

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
              <h3 class="card-header"><b>Data Pangan</b><hr style="border: 2px solid rgb(225, 225, 225);"></h3>
                <div class="card-body">
                    <div class="row justify-content-between mb-4">
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
                          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                           + Tambah Data
                          </button>
                        </div>
                    </div>
                  <div class="table-responsive ">
                    <table class="table table-bordered table-striped">
                      <thead class="table-warning">
                        <tr class="text-center justify-content-center">
                            <th>No</th>
                            <th>Nama Distributor</th>
                            <th>Jenis Pangan</th>
                            <th>Volume (Ton)</th>
                            <th>Asal (Kabupaten)</th>
                            <th>Tujuan Distribusi (Kabupaten)</th>
                            <th>Tanggal Pengiriman</th>
                            <th>Estimasi Kadarluarsa</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      
                      <tbody class="text-center justify-content-center">
                      @forelse ($strapa as $item)
                        <tr>
                            <td>{{ $strapa->firstItem() + $loop->index }}</td>
                            <td>{{ $item->produsen->nama_distributor }}</td>
                            <td>{{ $item->namaPangan->nama_pangan }}</td>
                            <td>{{ $item->volume }}</td>
                            <td>{{ $item->asalKabupaten->nama_kabupaten }}</td>
                            <td>{{ $item->tujuanKabupaten->nama_kabupaten }}</td>
                            <td>{{ $item->tanggal_pengiriman }}</td>
                            <td>{{ $item->estimasi_kadaluarsa }}</td>
                          <td>
                             <div class="text-center">
                                <button class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"><i class="icon-base bx bx-edit-alt me-1"></i></button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}"><i class="icon-base bx bx-trash me-1"></i></button>
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
                      <span class="text-muted mt-3">Total Data Pangan : {{ $strapa->total() }} Data</span>

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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('storepangan') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Pangan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          <hr style="border: black 2px solid;">
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Produsen</label>
              <select name="produsen_id" class="form-control" required>
                <option value="">Pilih Produsen</option>
                @foreach ($produsen as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_distributor }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label>Nama Pangan</label>
              <select name="nama_pangan_id" class="form-control" required>
                <option value="">Pilih Pangan</option>
                @foreach ($namaPangan as $np)
                  <option value="{{ $np->id }}">{{ $np->nama_pangan }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label>Volume (Ton)</label>
              <input type="number" step="0.01" name="volume" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label>Asal Kabupaten</label>
              <select name="asal_pangan" class="form-control" required>
                <option value="">Pilih Kabupaten Asal</option>
                @foreach ($kabupaten as $k)
                  <option value="{{ $k->id }}">{{ $k->nama_kabupaten }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label>Tujuan Kabupaten</label>
              <select name="tujuan_pangan" class="form-control" required>
                <option value="">Pilih Kabupaten Tujuan</option>
                @foreach ($kabupaten as $k)
                  <option value="{{ $k->id }}">{{ $k->nama_kabupaten }}</option>
                @endforeach
              </select>
            </div>
            
            <div class="col-md-6 mb-3">
              <label>Estimasi Kadaluarsa</label>
              <input type="date" name="estimasi_kadaluarsa" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label>Tanggal Pengiriman</label>
              <input type="date" name="tanggal_pengiriman" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach ($strapa as $item)
  <!-- Modal Edit -->
    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <form action="{{ route('updatepangan', $item->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data Pangan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row">
              <div class="col-md-6 mb-3">
                <label>Produsen</label>
                <select name="produsen_id" class="form-select" required>
                  @foreach($produsen as $p)
                  <option value="{{ $p->id }}" {{ $item->produsen_id == $p->id ? 'selected' : '' }}>{{ $p->nama_distributor }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label>Nama Pangan</label>
                <select name="nama_pangan_id" class="form-select" required>
                  @foreach($namaPangan as $np)
                  <option value="{{ $np->id }}" {{ $item->nama_pangan_id == $np->id ? 'selected' : '' }}>{{ $np->nama_pangan }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label>Volume (Ton)</label>
                <input type="number" name="volume" step="0.01" class="form-control" value="{{ $item->volume }}" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Asal Kabupaten</label>
                <select name="asal_pangan" class="form-select" required>
                  @foreach($kabupaten as $k)
                  <option value="{{ $k->id }}" {{ $item->asal_pangan == $k->id ? 'selected' : '' }}>{{ $k->nama_kabupaten }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label>Tujuan Kabupaten</label>
                <select name="tujuan_pangan" class="form-select" required>
                  @foreach($kabupaten as $k)
                  <option value="{{ $k->id }}" {{ $item->tujuan_pangan == $k->id ? 'selected' : '' }}>{{ $k->nama_kabupaten }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label>Tanggal Pengiriman</label>
                <input type="date" name="tanggal_pengiriman" class="form-control" value="{{ $item->tanggal_pengiriman }}" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Estimasi Kadaluarsa</label>
                <input type="date" name="estimasi_kadaluarsa" class="form-control" value="{{ $item->estimasi_kadaluarsa }}" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success" onclick="konfirmasiEdit(() => window.location.href='/edit/{{ $item->id }}')">Simpan Perubahan</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
@endforeach



<!-- Modal Delete -->
@foreach ($strapa as $item)
    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('destroypangan', $item->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Konfirmasi Hapus</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              Apakah Anda yakin ingin menghapus data pangan <strong>{{ $item->namaPangan->nama_pangan }}</strong> dari <strong>{{ $item->produsen->nama_distributor }}</strong> ?
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-warning">Hapus</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
@endforeach

@endsection