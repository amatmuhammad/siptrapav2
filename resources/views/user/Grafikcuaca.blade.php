@extends('user.partials.mainuser')

@section('judul', 'Grafik Cuaca')

@section('konten')

{{-- jumbotron --}}
    <div class="jumbotron jumbotron-fluid mb-5">
        <div class="container text-center py-5">
            <h1 class="text-primary display-3">Data Cuaca</h1>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-circle px-3"></i>
                <p class="m-0">Grafik Cuaca</p>
            </div>
        </div>
    </div>
{{-- jumbotron --}}

<div class="container-fluid">
    <div class="container">
        <div class="text-center pb-2">
            <h1 class="text-primary"> Grafik Perkiraan Cuaca</h1>
            <p>Grafik perkiraan cuaca menyajikan informasi real-time mengenai suhu, curah hujan, dan kondisi atmosfer lainnya untuk mendukung perencanaan distribusi pangan. Data ini membantu menyesuaikan rute secara efisien agar pengiriman tetap aman dan tepat waktu.</p>
        </div>
        <div class="row">
            <div class="col">
                <div class="card mb-5 shadow rounded-3" style="border-radius: 10px;">
                    <div class="card-body">
                        <h2>Grafik Perkiraan Cuaca</h2>
                        <hr style="border: 2px solid grey;">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <form method="GET" action="{{ route('Cuaca') }}" class="row g-2 align-items-end mb-4">
                                    <div class="col-md-4">
                                        <label for="kabupaten" class="form-label fw-bold">Pilih Kabupaten/Kota:</label>
                                        <select name="kabupaten" id="kabupaten" class="form-control" required>
                                            <option value="" class="text-center">------ Pilih Kabupaten -----</option>
                                            @foreach($kabupaten as $kota)
                                                <option value="{{ $kota->latitude }},{{ $kota->longitude }}"
                                                    {{ request('kabupaten') == "$kota->latitude,$kota->longitude" ? 'selected' : '' }}>
                                                    {{ $kota->nama_kabupaten }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-outline-warning w-100">
                                            <i class="fas fa-cloud-sun"></i> Cek Cuaca
                                        </button>
                                    </div>
                                </form>


                            </div>
                        </div>
                        <canvas id="weatherChart" width="800" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const weatherData = Object.values(@json($weatherData));

    const labels = weatherData.map(item => item.time);
    const suhu = weatherData.map(item => item.temp);
    const kelembapan = weatherData.map(item => item.humidity);
    const angin = weatherData.map(item => item.wind);
    const hujan = weatherData.map(item => item.rain); // Tambah curah hujan

    const ctx = document.getElementById('weatherChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Suhu (°C)',
                    data: suhu,
                    borderColor: 'red',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    yAxisID: 'y'
                },
                {
                    label: 'Kelembapan (%)',
                    data: kelembapan,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    yAxisID: 'y1'
                },
                {
                    label: 'Kecepatan Angin (m/s)',
                    data: angin,
                    borderColor: 'green',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    yAxisID: 'y2'
                },
                {
                    label: 'Curah Hujan (mm)',
                    data: hujan,
                    borderColor: 'purple',
                    backgroundColor: 'rgba(153, 102, 255, 0.3)',
                    yAxisID: 'y3'
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            stacked: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Cuaca 3 Hari (Per 3 Jam)'
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    title: { display: true, text: 'Suhu (°C)' }
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    title: { display: true, text: 'Kelembapan (%)' }
                },
                y2: {
                    type: 'linear',
                    position: 'right',
                    offset: true,
                    grid: { drawOnChartArea: false },
                    title: { display: true, text: 'Angin (m/s)' }
                },
                y3: {
                    type: 'linear',
                    position: 'right',
                    offset: true,
                    grid: { drawOnChartArea: false },
                    title: { display: true, text: 'Curah Hujan (mm)' }
                }
            }
        }
    });
</script>


@endsection