@extends('layouts.main')

@section('judul', 'Dashboard Admin')

@section('konten')

<div class="container-xl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-start row">
            <div class="col-md-6">
              <div class="card-body">
                <h3 class="card-title text-warning mb-3 mt-4">Selamat Datang Admin</h3>
                <p class="mb-6">
                  Kamu Dapat Memantau Data Komoditas Pangan Dari Sini.<br />Ayok Mulai Sadar Akan Kualitas Pangan
                </p>

                {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> --}}
              </div>
            </div>
            <div class="col-md-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-6">
                <img
                  src="{{ asset('assets1/assets/img/illustrations/Vector.png') }}"
                  height="175"
                  alt="View Badge User" />
              </div>
            </div>
          </div>
        </div>
      </div>

    {{-- chart --}}
    <div class="chart">
      <div class="card">
        <div class="card-body">
          <h4 class="mb-4">Grafik Data Pangan Setiap Kabupaten</h4>
          <hr style="border: 2px solid rgb(225, 225, 225);">
          <div class="row">
            <div class="col-12 ms-auto">
              <form method="GET" action="{{ route('Dashboard') }}" class="mb-4 row">
                  <div class="col-md-3 mb-2">
                      <label>Nama Pangan:</label>
                      <select name="nama_pangan_id" class="form-control">
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
                      <select name="bulan" class="form-control">
                          <option value="">--- Pilih Bulan ---</option>
                          @foreach($bulanList as $bulan)
                              <option value="{{ $bulan }}" {{ $filter_bulan == $bulan ? 'selected' : '' }}>
                                  {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-4 d-flex align-items-end d-grid gap-2 mb-2">
                      <button class="btn btn-warning" type="submit">Tampilkan Grafik</button>
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

{{-- script js --}}
{{-- <script>
  const ctx = document.getElementById('grafikKabupaten').getContext('2d');

  const chart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: @json($data->pluck('nama_kabupaten')),
          datasets: [{
              label: 'Pangan (Ton)',
              data: @json($data->pluck('total_volume')),
              backgroundColor: [
                  'rgba(255, 99, 132, 0.4)',
                  'rgba(255, 159, 64, 0.4)',
                  'rgba(255, 205, 86, 0.4)',
                  'rgba(75, 192, 192, 0.4)',
                  'rgba(54, 162, 235, 0.4)',
                  'rgba(153, 102, 255, 0.4)',
                  'rgba(201, 203, 207, 0.4)',
                  'rgba(255, 99, 255, 0.4)',
                  'rgba(99, 255, 132, 0.4)',
                  'rgba(159, 64, 255, 0.4)',
                  'rgba(205, 86, 255, 0.4)',
                  'rgba(102, 153, 255, 0.4)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(255, 205, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(201, 203, 207, 1)',
                  'rgba(255, 99, 255, 1)',
                  'rgba(99, 255, 132, 1)',
                  'rgba(159, 64, 255, 1)',
                  'rgba(205, 86, 255, 1)',
                  'rgba(102, 153, 255, 1)'
              ],
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

</script> --}}
  
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