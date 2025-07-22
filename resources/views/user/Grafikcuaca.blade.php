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
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum nihil nostrum necessitatibus voluptatum, qui at nam veniam placeat quod animi exercitationem tenetur repellat iusto? Facere, consequuntur repellat repudiandae eius ab fuga excepturi incidunt veniam nulla sunt. Cupiditate iure mollitia amet?</p>
        </div>
        <div class="row">
            <div class="col">
                <div class="card mb-5 shadow rounded-3" style="border-radius: 10px;">
                    <div class="card-body">
                        <h2>Grafik Perkiraan Cuaca</h2>
                        <canvas id="weatherChart" width="800" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    {{-- <script>
        const weatherData = @json($weatherData);

        const labels = weatherData.map(item => item.time);
        const suhu = weatherData.map(item => item.temp);
        const kelembapan = weatherData.map(item => item.humidity);
        const angin = weatherData.map(item => item.wind);
        const hujan = weatherData.map(item => item.rain);

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
                        Label: 'Curah Hujan(mm)',
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
                        grid: { drawOnChartArea: false },
                        offset: true,
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
    </script> --}}

    <script>
    const weatherData = @json($weatherData);

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