@extends('user.partials.mainuser')

@section('judul','Grafik Distribusi')

@section('konten')

<style>
    #map { 
        height: 480px;
        width: 100%;
        z-index: 1;
        /* border-radius: 10px; */
    
    }

    #legend {
        background: rgba(255, 255, 255, 0.855);
        padding: 10px;
        border-radius: 5px;
        position: absolute;
        margin-left: 20px;
        bottom: 30px;
        left: 10px;
        z-index: 1000;
        font-size: 14px;
        box-shadow: 0 0 8px rgba(0,0,0,0.3);
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .legend-color {
        width: 16px;
        height: 16px;
        margin-right: 8px;
        border: 1px solid #333;
    }
</style>


{{-- jumbotron --}}
    <div class="jumbotron jumbotron-fluid mb-5">
        <div class="container text-center py-5">
            <h1 class="text-primary display-3">Data Distribusi</h1>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-circle px-3"></i>
                <p class="m-0">Grafik Distribusi</p>
            </div>
        </div>
    </div>
{{-- jumbotron --}}


    <div class="container-fluid">
        <div class="text-center">
            <h1>Data Distributor Pangan Sulawesi Tenggara</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum illo facilis veritatis quam molestias animi fugit quo, eveniet similique! Corporis iure perspiciatis, inventore doloremque molestiae cumque explicabo quae consequuntur quibusdam? Numquam veritatis voluptatem, accusamus voluptas mollitia vel dolores eos repellat dicta! Ratione, repellat delectus ad doloremque eius ea veritatis nobis.</p>
        </div>

        {{-- <div id="customCardCarousel" class="carousel slide mt-5 mb-5" data-ride="carousel">
            <div class="carousel-inner">

                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                    <div class="d-flex justify-content-center flex-wrap">
                        <div class="card mb-3 mx-2" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                            <img src="{{ asset('assets2/images/Baubau.png') }}" class="img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">PT. Buton Raya Pangan</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, eius?</p>
                                <p class="card-text"><small class="text-muted">Last updated 1 min ago</small></p>
                            </div>
                            </div>
                        </div>
                        </div>

                        <div class="card mb-3 mx-2" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                            <img src="{{ asset('assets2/images/muna.png') }}" class="img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">PT. Muna Pangan Berseri</h5>
                                <p class="card-text">Isi konten card 2.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                            </div>
                        </div>
                        </div>

                    </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                    <div class="d-flex justify-content-center flex-wrap">
                        <div class="card mb-3 mx-2" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                            <img src="{{ asset('assets2/images/Baubau.png') }}" class="img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">PT. Kolaka Cipta pangan</h5>
                                <p class="card-text">Isi konten card 3.</p>
                                <p class="card-text"><small class="text-muted">Last updated 5 mins ago</small></p>
                            </div>
                            </div>
                        </div>
                        </div>

                        <div class="card mb-3 mx-2" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                            <img src="{{ asset('assets2/images/Baubau.png') }}" class="img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">CV. Beras abadi</h5>
                                <p class="card-text">Isi konten card 4.</p>
                                <p class="card-text"><small class="text-muted">Last updated 6 mins ago</small></p>
                            </div>
                            </div>
                        </div>
                        </div>

                        <div class="card mb-3 mx-2" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                            <img src="{{ asset('assets2/images/Baubau.png') }}" class="img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Konawe Pangan</h5>
                                <p class="card-text">Isi konten card 5.</p>
                                <p class="card-text"><small class="text-muted">Last updated 8 mins ago</small></p>
                            </div>
                            </div>
                        </div>
                        </div>

                    </div>
                    </div>

            </div>

        </div> --}}

@php
    $distributors = [
        [
            'name' => 'PT. Buton Raya Pangan',
            'image' => 'assets2/images/Baubau.png',
            'description' => 'Distributor pangan di wilayah Baubau.',
            'updated' => 'Last updated 1 min ago'
        ],
        [
            'name' => 'PT. Muna Pangan Berseri',
            'image' => 'assets2/images/muna.png',
            'description' => 'Distributor utama di Muna.',
            'updated' => 'Last updated 3 mins ago'
        ],
        [
            'name' => 'PT. Kolaka Cipta Pangan',
            'image' => 'assets2/images/Baubau.png',
            'description' => 'Distribusi Kolaka dan sekitarnya.',
            'updated' => 'Last updated 5 mins ago'
        ],
        [
            'name' => 'CV. Beras Abadi',
            'image' => 'assets2/images/Baubau.png',
            'description' => 'Spesialis beras lokal.',
            'updated' => 'Last updated 6 mins ago'
        ],
        [
            'name' => 'Konawe Pangan',
            'image' => 'assets2/images/Baubau.png',
            'description' => 'Distribusi daerah Konawe.',
            'updated' => 'Last updated 8 mins ago'
        ]
    ];
@endphp

    <div id="customCardCarousel" class="carousel slide mt-5 mb-5" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">

            @foreach (array_chunk($distributors, 2) as $index => $chunk)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="d-flex justify-content-center flex-wrap">
                        @foreach ($chunk as $dist)
                            <div class="card mb-3 mx-2" style="max-width: 540px;">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img src="{{ asset($dist['image']) }}" class="img-fluid" alt="{{ $dist['name'] }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $dist['name'] }}</h5>
                                            <p class="card-text">{{ $dist['description'] }}</p>
                                            <p class="card-text"><small class="text-muted">{{ $dist['updated'] }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Navigasi -->
        <a class="carousel-control-prev" href="#customCardCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#customCardCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>


</div>
    
<div class="container-fluid" >
    
        <div class="row">
            <div class="col">
                <div class="card shadow mb-4 rounded-3">
                    <div class="card-body">
                        <h4><strong>Matriks Distribusi</strong></h4>
                        <div class="map rounded" id="map"></div>
                        <div id="legend" style="padding:10px;"></div>        
                    </div>
                </div>
            </div>
        </div>

</div>


<script>
    var map = L.map('map').setView([-4.009, 122.52], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Palet warna kontras tinggi
    const colorPalette = [
        "#e6194b", "#3cb44b", "#ffe119", "#4363d8", "#f58231", "#911eb4",
        "#46f0f0", "#f032e6", "#bcf60c", "#fabebe", "#008080", "#e6beff",
        "#9a6324", "#fffac8", "#800000", "#aaffc3", "#808000", "#ffd8b1",
        "#000075", "#808080", "#000000"
    ];

    const dataDistribusi = @json($dataDistribusi);

    const panganColorMap = {}; // nama_pangan => color
    let colorIndex = 0;

    // Ambil semua volume untuk skala ketebalan
    const volumes = dataDistribusi.map(d => d.volume || 0);
    const minVol = Math.min(...volumes);
    const maxVol = Math.max(...volumes);

    function scaleWeight(volume) {
        if (maxVol === minVol) return 5;
        return 2 + ((volume - minVol) / (maxVol - minVol)) * (10 - 2);
    }

    dataDistribusi.forEach(item => {
        const from = item.asal_kabupaten;
        const to = item.tujuan_kabupaten;
        const namaPangan = item.nama_pangan?.nama_pangan || 'Lainnya';
        const volume = item.volume || 0;

        if (!from || !to) return;

        // Tetapkan warna unik untuk setiap jenis pangan
        if (!panganColorMap[namaPangan]) {
            panganColorMap[namaPangan] = colorPalette[colorIndex % colorPalette.length];
            colorIndex++;
        }

        const color = panganColorMap[namaPangan];
        const weight = scaleWeight(volume);

        // Offset jika asal dan tujuan sama
        let toLat = to.latitude;
        let toLng = to.longitude;

        if (from.latitude === to.latitude && from.longitude === to.longitude) {
            const offset = 0.02;
            toLat += (Math.random() - 0.5) * offset;
            toLng += (Math.random() - 0.5) * offset;
        }

        // Marker asal
        L.marker([from.latitude, from.longitude])
            .addTo(map)
            .bindPopup("Asal: " + from.nama_kabupaten);

        // Marker tujuan
        L.marker([to.latitude, to.longitude])
            .addTo(map)
            .bindPopup("Tujuan: " + to.nama_kabupaten);

        // Garis distribusi
        L.polyline([
            [from.latitude, from.longitude],
            [toLat, toLng]
        ], {
            color: color,
            weight: weight,
            opacity: 0.8
        }).addTo(map).bindTooltip(`
            <strong>${namaPangan}</strong><br>
            Volume: ${volume} ton<br>
            Dari: ${from.nama_kabupaten}<br>
            Ke: ${to.nama_kabupaten}
        `);
    });

    // Legenda dinamis berdasarkan data pangan aktual
    let legendHtml = "<strong>Legenda Matriks Distribusi</strong><br>";
    for (let pangan in panganColorMap) {
        const color = panganColorMap[pangan];
        legendHtml += `
            <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 4px;">
                <div class="legend-color" style="width: 20px; height: 10px; background-color: ${color}; margin-right: 8px;"></div>
                <span>${pangan}</span>
            </div>
        `;
    }
    document.getElementById('legend').innerHTML = legendHtml;
</script>



@endsection