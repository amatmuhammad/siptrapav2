@extends('layouts.main')

@section('judul','Edge')

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
                <h3 class="card-header"><b>Data Edge</b><hr style="border: 2px solid rgb(225, 225, 225);"></h3>
                <div class="card-body">
                    <div class="row justify-content-between">
                      <div class="col">
                        <span class="me-1">Show</span>
                              <form method="GET" action="{{ route('Edge') }}">
                                  <select name="show_entries" class="form-control" onchange="this.form.submit()" style="width: auto;">
                                      <option value="10" {{ request()->get('show_entries') == 10 ? 'selected' : '' }}>10</option>
                                      <option value="25" {{ request()->get('show_entries') == 25 ? 'selected' : '' }}>25</option>
                                      <option value="50" {{ request()->get('show_entries') == 50 ? 'selected' : '' }}>50</option>
                                      <option value="100" {{ request()->get('show_entries') == 100 ? 'selected' : '' }}>100</option>
                                  </select>
                                </form>
                        </div>
                        <div class="col-md-4 mb-5">
                          <form action="{{ route('Edge') }}" method="GET" >
                            <label for="Search">Cari Edge</label>
                            <input type="text" class="form-control" name="search" id="search" placeholder="Cari Data Edge..." value="{{ request()->get('search', session('search_node')) }}" />
                          </form>
                        </div>
                        
                    </div>
                  <div class="table-responsive ">
                    <table class="table table-bordered table-striped">
                      <thead class="table-warning">
                        <tr class="text-center">
                          <th>No</th>
                          <th>Source</th>
                          <th>Target</th>
                          <th>Distance</th>
                          {{-- <th>Actions</th> --}}
                        </tr>
                      </thead>
                      
                      <tbody class="text-center">
                      @forelse ($strapa as $item)
                        <tr>
                          <td>
                            {{ $strapa->firstItem() + $loop->index }}
                          </td>
                          <td>{{ $item->source }}</td>
                          <td>
                            {{$item->target}}
                          </td>
                          <td>{{ $item->distance }}</td>
                          {{-- <td> --}}
                            
                             <div>
                                {{-- <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModalEdge{{ $item->id }}"><i class="icon-base bx bx-edit-alt me-1"></i></button> --}}
                                {{-- <button class="btn btn-danger"> <i class="icon-base bx bx-trash me-1"></i></button> --}}
                            </div>                              
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
                      <span class="text-muted">Total Data Edge : {{ $strapa->total() }} Data</span>
                      {{-- <div>
                          {{ $strapa->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
                      </div> --}}

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

@foreach($strapa as $item)
<div class="modal fade" id="updateModalEdge{{ $item->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog" style="margin-top: 150px;">
    <form action="{{ route('updateEdge', $item->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Edge</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <div class="mb-2">
            <label>Source Node</label>
            <input type="text" name="source" class="form-control" value="{{ $item->source }}">
          </div>

          <div class="mb-2">
            <label>Target Node</label>
            <input type="text" name="target" class="form-control" value="{{ $item->target }}">
          </div>

          <div class="mb-2">
            <label>Distance (km)</label>
            <input type="number" step="0.001" name="distance" class="form-control" value="{{ $item->distance }}" disabled>
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
@endforeach


@endsection