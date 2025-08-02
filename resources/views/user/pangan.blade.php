@extends('user.partials.mainuser')

@section('konten')

<div class="jumbotron jumbotron-fluid mb-5">
    <div class="container text-center py-5">
        <h1 class="text-primary display-4 mb-4">Grafik Data Pangan</h1>
        <h1 class="text-white display-3 mb-5">Sulawesi Tenggara</h1>
    </div>
</div>

<div class="container-fluid">
    <div class="row mb-5">
        <div class="col text-center">
            <img src="{{ asset('assets2/images/pangan.png') }}" alt="image" style="width: 90%;">
        </div>
        <div class="col mt-5">
            <h4 class="text-primary">Distribusi Pangan</h4>
            <h1>Distribusi Pangan Sulawesi Tenggara</h1>
            <p class="text-justify mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi placeat velit libero magni, ullam, voluptates sit quibusdam odit magnam natus officia accusamus excepturi voluptatem beatae architecto tenetur dolorum iure. Quidem, eaque architecto? Nobis tempora eaque minima incidunt quos, tenetur suscipit ut repudiandae nemo nesciunt fugiat odit velit quas, minus adipisci voluptatum nam deleniti facere! Voluptates ab aspernatur unde illo rem fugiat ea distinctio, fugit voluptatem earum molestias, aperiam excepturi temporibus est quaerat reprehenderit maxime, ex dolor ipsum. Hic dolores inventore eos rem facilis id nemo veniam nostrum, aut unde est ipsam, esse porro. Possimus et, consectetur cupiditate iusto veniam magnam.<p>
        </div>
    </div>
</div>
    
<div class="container-fluid bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card mt-5 mb-5 shadow" style="border-radius: 20px;">
                    <div class="card-body">
                        <h2>Grafik Data Kabupaten Penghasil Pangan</h2>
                        <hr style="border: 2px solid rgb(225, 225, 225);">
                        <div class="row">
                            <div class="col-12 ms-auto">
                            <form method="GET" action="{{ route('pangan') }}" class="mb-4 row">
                                <div class="col-md-3 mb-2">
                                    <label>Nama Pangan:</label>
                                    <select name="nama_pangan_id" class="form-control rounded">
                                        <option value="">--- Semua Pangan ---</option>
                                        @foreach($nama_pangan as $np)
                                            <option value="{{ $np->id }}" {{ $filter_pangan == $np->id ? 'selected' : '' }}>
                                                {{ $np->nama_pangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>Bulan:</label>
                                    <select name="bulan" class="form-control rounded">
                                        <option value="">--- Pilih Bulan ---</option>
                                        @foreach($bulanList as $bulan)
                                            <option value="{{ $bulan }}" {{ $filter_bulan == $bulan ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end d-grid gap-2 mb-2">
                                    <button class="btn btn-outline-warning rounded" type="submit">Tampilkan Grafik</button>
                                </div>
                            </form>

                            </div>
                        </div>
                        
                        @if ($data->isEmpty())
                            <div class="alert alert-warning">
                            Data tidak ditemukan untuk filter yang dipilih.
                            </div>
                        @else
                            {{-- <canvas class="grafik" id="grafikKabupaten"></canvas> --}}
                            <canvas id="grafikKabupaten"></canvas>
                            
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  const ctx = document.getElementById('grafikKabupaten').getContext('2d');

  const chart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: [],
          datasets: [{
              label: 'Pangan (Ton)',
              data: [],
              backgroundColor: [],
              borderColor: [],
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          scales: {
              y: {
                  beginAtZero: true,
                  title: {
                      display: true,
                      text: 'Volume (Ton)'
                  }
              }
          }
      }
  });

  function getRandomColor(index) {
      const hue = (index * 47) % 360;
      return `hsl(${hue}, 70%, 70%)`;
  }

  async function loadChartData() {
      try {
          const url = `{{ url('/Dashboard') }}?bulan={{ $filter_bulan }}&nama_pangan_id={{ $filter_pangan }}`;
          const response = await fetch(url, {
              headers: {
                  'X-Requested-With': 'XMLHttpRequest' // agar terdeteksi sebagai AJAX
              }
          });
          const result = await response.json();

          const labels = result.map(item => item.nama_kabupaten);
          const data = result.map(item => parseFloat(item.total_volume));
          const bgColor = result.map((_, i) => getRandomColor(i));
          const bdColor = result.map((_, i) => getRandomColor(i));

          chart.data.labels = labels;
          chart.data.datasets[0].data = data;
          chart.data.datasets[0].backgroundColor = bgColor;
          chart.data.datasets[0].borderColor = bdColor;

          chart.update();
      } catch (e) {
          console.error("Gagal load data:", e);
      }
  }

  // Load pertama kali
  loadChartData();

  // Update setiap 10 detik
  setInterval(loadChartData, 10000);
</script>
@endsection