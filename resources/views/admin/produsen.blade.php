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
                    <div class="row justify-content-between mb-4">
                      <div class="col d-flex align-items-center mb-3 mb-md-0">
                        <span class="me-1">Show Data</span>
                        <form method="GET" action="{{ route('produsen') }}">
                                  <select name="show_entries" class="form-control" onchange="this.form.submit()" style="width: auto;">
                                      <option value="10" {{ request()->get('show_entries') == 10 ? 'selected' : '' }}>10</option>
                                      <option value="25" {{ request()->get('show_entries') == 25 ? 'selected' : '' }}>25</option>
                                      <option value="50" {{ request()->get('show_entries') == 50 ? 'selected' : '' }}>50</option>
                                      <option value="100" {{ request()->get('show_entries') == 100 ? 'selected' : '' }}>100</option>
                                  </select>
                                </form>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0 text-md-end">
                          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                           + Tambah Data
                          </button>
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
                            <th>Alamat</th>
                            <th>Wilayah Cakupan</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      
                      <tbody class="text-center">
                      @forelse ($strapa as $item)
                        <tr>
                            <td>{{ $strapa->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nama_distributor }}</td>
                            <td>{{ $item->nama_pemilik }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->jenis_pangan }}</td>
                            <td>{{ $item->jenis_distributor }}</td>
                            <td>{{ $item->asalKabupaten->nama_kabupaten ?? '-' }}</td>
                            <td>{{ $item->alamat_distributor }}</td>
                            <td>{{ $item->wilayah_cakupan }}</td>
                          <td>
                             <div>
                                <button class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"><i class="icon-base bx bx-edit-alt me-1"></i></button>
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
                      <span class="text-muted">Total Data Distributor : {{ $strapa->total() }} Data</span>

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

<!-- Modal Form Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('storeprodusen') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahModalLabel">Tambah Distributor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Nama Distributor</label>
            <input type="text" name="nama_distributor" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Nama Pemilik</label>
            <input type="text" name="nama_pemilik" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Jenis Pangan</label>
            <select name='jenis_pangan' class="form-control" required>
              <option value="">-- Pilih Jenis Pangan --</option>
              @foreach ($pangan as $k)
                  <option  value="{{ $k->nama_pangan }}">{{ $k->nama_pangan }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-2">
            <label>Jenis Distributor</label>
            <select name='jenis_distributor' id="jenis_pangan" class="form-control">
                <option value="">-- Semua Jenis --</option>
                @foreach($Jenis as $j)
                    <option  value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
          </div>
          <div class="mb-2">
            <label>Asal Kabupaten</label>
            <select name="asal" class="form-control" required>
              <option value="">-- Pilih Kabupaten --</option>
              @foreach ($kabupaten as $k)
                  <option value="{{ $k->id }}">{{ $k->nama_kabupaten }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-2">
            <label>Alamat Distributor</label>
            <textarea name="alamat_distributor" class="form-control"></textarea>
          </div>
          <div class="mb-2">
            <label>Wilayah Cakupan</label>
            <input type="text" name="wilayah_cakupan" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>


@foreach ($strapa as $d)
<div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $d->id }}" aria-hidden="true">
      <div class="modal-dialog">
        <form action="{{ route('updateprodusen', $d->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel{{ $d->id }}">Edit Distributor</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-2">
                <label>Nama Distributor</label>
                <input type="text" name="nama_distributor" class="form-control" value="{{ $d->nama_distributor }}" required>
              </div>
              <div class="mb-2">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ $d->no_hp }}" required>
              </div>
              <div class="mb-2">
                <label>Nama Pemilik</label>
                <input type="text" name="nama_pemilik" class="form-control" value="{{ $d->nama_pemilik }}" required>
              </div>
              <div class="mb-2">
                <label>Jenis Pangan</label>
                <select name='jenis_pangan' class="form-control" required>
                  <option value="">-- Pilih Jenis Pangan --</option>
                  @foreach ($pangan as $k)
                    <option value="{{ $k->nama_pangan }}" {{ $d->jenis_pangan == $k->nama_pangan ? 'selected' : '' }}>
                      {{ $k->nama_pangan }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="mb-2">
                <label>Jenis Distributor</label>
                <select name='jenis_distributor' id="jenis_pangan" class="form-control">
                  <option value="">-- Semua Jenis --</option>
                  @foreach($Jenis as $j)
                      <option value="{{ $j }}" {{ $d->jenis_distributor == $j ? 'selected' : '' }}>{{ $j }}</option>
                  @endforeach
              </select>
              </div>
              <div class="mb-2">
                <label>Asal Kabupaten</label>
                <select name="asal" class="form-control" required>
                  <option value="">-- Pilih --</option>
                  @foreach ($kabupaten as $k)
                    <option value="{{ $k->id }}" {{ $d->asal == $k->id ? 'selected' : '' }}>
                      {{ $k->nama_kabupaten }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="mb-2">
                <label>Alamat Distributor</label>
                <textarea name="alamat_distributor" class="form-control">{{ $d->alamat_distributor }}</textarea>
              </div>
              <div class="mb-2">
                <label>Wilayah Cakupan</label>
                <input type="text" name="wilayah_cakupan" class="form-control" value="{{ $d->wilayah_cakupan }}">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan Perubahan</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </td>
</tr>
@endforeach

@foreach ($strapa as $d)  
<!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="deleteModal{{ $d->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $d->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('destroyprodusen', $d->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus distributor <strong>{{ $d->nama_distributor }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Ya, Hapus</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </td>
</tr>
@endforeach


@endsection