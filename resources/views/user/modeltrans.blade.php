@extends('user.partials.mainuser')

@section('judul','Model Transportasi')

@section('konten')

<style>

    #map {
        height: 580px;
        border-radius: 10px;
        z-index: 1;
    }

    .map-controls {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.95);
        padding: 10px;
        border-radius: 8px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .route-info {
        position: absolute;
        top: 100px;
        right: 15px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.832);
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 14px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    /* Responsive behavior */
    @media (max-width: 576px) {
        .map-controls{
            left: 15px;
            right: 15px;
            flex-direction: column;
            align-items: stretch;
        }
        .route-info{
            left: 15px;
            right: 15px;
            margin-top: 20px;
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
        

{{-- jumbotron --}}
<div class="jumbotron jumbotron-fluid mb-5">
    <div class="container text-center py-5">
        <h1 class="text-primary display-3">Model Transportasi Pangan Berbasis Data Real Time</h1>
        <div class="d-inline-flex align-items-center text-white">
            <p class="m-0"><a class="text-white" href="">Home</a></p>
            <i class="fa fa-circle px-3"></i>
            <p class="m-0">Model Distribusi Pangan</p>
        </div>
    </div>
</div>
{{-- jumbotron --}}

<div class="container-fluid">
    <div class="container">
        <div class="text-center pb-2">
            <h1 class="text-primary"> Model Distribusi Pangan</h1>
            <p>Model transportasi yang digunakan dalam sistem ini dirancang untuk mendukung distribusi pangan secara efisien, adaptif, dan berbasis data real-time. Sistem memanfaatkan algoritma pemetaan rute cerdas yang mempertimbangkan berbagai faktor seperti kondisi cuaca, jarak tempuh, waktu tempuh, serta ketersediaan jalur alternatif. Dengan pendekatan ini, proses distribusi dapat dilakukan secara lebih cepat dan tepat, sekaligus meminimalkan risiko keterlambatan atau gangguan selama perjalanan. Model ini juga fleksibel dan dapat disesuaikan dengan kebutuhan logistik di berbagai wilayah, baik daratan maupun kepulauan.</p>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row mt-5">
            <div class="col">
                <div class="card mb-5 shadow rounded-3" style="border-radius: 10px;">
                    <div class="card-body">
                        <h4 class="mb-4">Peta Pemodelan Distribusi Pangan </h4>
                        <hr style="border: 2px solid rgb(225, 225, 225);">
                        
                        @if (isset($cuaca))
                            <div class="alert alert-{{ $alert_level }} mt-3">
                                <h5><strong>Informasi Cuaca & Waktu Tempuh</strong></h5>
                                <p>{{ $alert_message }}</p>

                                <div class="row">
                                    <!-- Kolom 1 -->
                                    <div class="col-md-4 mb-2">
                                        <ul>
                                            <li><strong>Deskripsi:</strong> {{ $cuaca['description'] }}</li>
                                            <li><strong>Suhu:</strong> {{ $cuaca['temperature'] }} °C</li>
                                        </ul>
                                    </div>

                                    <!-- Kolom 2 -->
                                    <div class="col-md-4 mb-2">
                                        <ul>
                                            <li><strong>Kelembaban:</strong> {{ $cuaca['humidity'] }} %</li>
                                            <li><strong>Angin:</strong> {{ $cuaca['wind'] }} m/s</li>
                                        </ul>
                                    </div>

                                    <!-- Kolom 3 -->
                                    <div class="col-md-4 mb-2">
                                        <ul>
                                            <li><strong>Hujan:</strong> {{ $cuaca['rain'] }} mm (3 jam)</li>
                                            <li><strong>Waktu:</strong> {{ $cuaca['timestamp'] }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                            <ul>
                                            @if(isset($waktu_tempuh))
                                                <li><strong>Waktu Tempuh (Rute Utama):</strong> {{ $waktu_tempuh['jam'] }} jam {{ $waktu_tempuh['menit'] }} menit</li>
                                            @endif

                                            @if(isset($waktu_tempuh_alt))
                                                <li><strong>Waktu Tempuh (Alternatif):</strong> {{ $waktu_tempuh_alt['jam'] }} jam {{ $waktu_tempuh_alt['menit'] }} menit</li>
                                            @endif

                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul>
                                            @if(isset($biaya_utama))
                                                <li>
                                                    <strong>
                                                        <span role="button" data-toggle="modal" data-target="#biayaModal" style="cursor: pointer;">
                                                            Estimasi Biaya (Rute Utama) : 
                                                        </span>
                                                    </strong>
                                                    Rp{{ number_format($biaya_utama, 0, ',', '.') }}
                                                </li>
                                            @endif

                                            @if(isset($biaya_alternatif))
                                                <li>
                                                    <strong>
                                                        <span role="button" data-toggle="modal" data-target="#biayaModal" style="cursor: pointer;">
                                                            Estimasi Biaya (Rute Alternatif) : 
                                                        </span>
                                                    </strong> Rp {{ number_format($biaya_alternatif, 0, ',', '.') }}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                    
                            </div>
                            <div class="modal fade" id="biayaModal" tabindex="-1" aria-labelledby="biayaModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                    <form action="#" method="POST">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="addNodeModalLabel">Informasi Perhitungan Estimasi Biaya</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body">
                                            <p>Perhitungan estimasi biaya distribusi dihitung berdasarkan jarak rute dengan ketentuan sebagai berikut:</p>
                                            <ul>
                                                <li><strong>Jarak ≤ 5 km:</strong> Biaya tetap Rp10.000</li>
                                                <li><strong>Jarak 5–20 km:</strong> Tambahan Rp5.000 per km di atas 5 km</li>
                                                <li><strong>Jarak > 20 km:</strong> Tambahan Rp5.000/km untuk 6–20 km dan Rp10.000/km untuk km di atas 20</li>
                                            </ul>
                                            <p>Contoh:</p>
                                            <ul>
                                                <li>Jarak 4 km → Biaya = Rp10.000</li>
                                                <li>Jarak 10 km → Biaya = Rp10.000 + (5 km × Rp5.000) = Rp35.000</li>
                                                <li>Jarak 25 km → Biaya = Rp10.000 + (15 × Rp5.000) + (5 × Rp10.000) = Rp135.000</li>
                                            </ul>
                                            <p>Biaya ini digunakan untuk estimasi logistik atau distribusi pada rute yang dipilih.</p>
                                        </div>

                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div style="position: relative;">
                            {{-- Kontrol UI --}}
                            <div class="map-controls">
                                <button type="button" class="btn btn-success rounded" data-toggle="modal" data-target="#exampleModal">
                                    Buat Rute
                                </button>

                                <button type="button" id="btn-clear" class="btn btn-danger rounded">
                                    Hapus Rute
                                </button>
                            </div>

                            {{-- Info jarak dan waktu --}}
                            <div class="route-info">
                                <p><strong>Legenda Jalur</strong></p>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 30px; height: 5px; background-color: blue;"></div>
                                    <span>Rute Utama 
                                        @if(isset($distance_km))
                                            ({{ number_format($distance_km, 2) }} km)
                                        @endif
                                    </span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-top: 6px;">
                                    <div style="width: 30px; height: 5px; background-color: red;"></div>
                                    <span>Rute Alternatif 
                                        @if(isset($distance_alt_km))
                                            ({{ number_format($distance_alt_km, 2) }} km)
                                        @endif
                                    </span>
                                </div>
                                @if(isset($execution_time))
                                    <hr>
                                    <p><strong>Waktu Eksekusi:</strong> {{ number_format($execution_time, 2) }} detik</p>
                                @endif
                            </div>


                            {{-- Peta --}}
                            <div id="map"></div>
                        </div>
                    </div>
                        <input type="hidden" id="hiddenStart" value="{{ $start_node ?? '' }}">
                        <input type="hidden" id="hiddenEnd" value="{{ $end_node ?? '' }}">
                    </div>
                </div>
            </div>
        </div>
</div>


    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Buat Model Transportasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <form method="POST" action="{{ route('cariRute') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Asal</label>
                        <select class="form-control" name="start_node" required>
                            <option value="">-- Pilih Kabupaten Asal --</option>
                            @foreach ($node as $n)
                                <option value="{{ $n->name }}" {{ old('start_node', $start_node ?? '') == $n->name ? 'selected' : '' }}>
                                    {{ $n->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tujuan</label>
                       <select class="form-control" name="end_node" required>
                            <option value="">-- Pilih Kabupaten Tujuan --</option>
                            @foreach ($node as $n)
                                <option value="{{ $n->name }}" {{ old('end_node', $end_node ?? '') == $n->name ? 'selected' : '' }}>
                                    {{ $n->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pangan</label>
                        <select name="jenis_pangan" class="form-control" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="buah" {{ old('jenis_pangan', $jenis_pangan ?? '') == 'buah' ? 'selected' : '' }}>Buah</option>
                            <option value="sayur" {{ old('jenis_pangan', $jenis_pangan ?? '') == 'sayur' ? 'selected' : '' }}>Sayur</option>
                            <option value="beras" {{ old('jenis_pangan', $jenis_pangan ?? '') == 'beras' ? 'selected' : '' }}>Beras</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Volume (Ton)</label>
                        <input type="number" step="0.1" min="0" class="form-control" name="volume"
                            placeholder="Masukkan Volume" required
                            value="{{ old('volume', $volume ?? '') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="buatRuteBtn">Cari Rute</button>
                </div>
            </form>


        </div>
    </div>
</div>

<script>
    const map = L.map('map').setView([-4.0, 122.5], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const routeMain = {!! json_encode($rute ?? []) !!};
    const routeAlt = {!! json_encode($jalur_alternatif ?? []) !!};
    const startNode = {!! json_encode($start_node ?? null) !!};
    const endNode = {!! json_encode($end_node ?? null) !!};

    if (routeMain.length) {
        L.polyline(routeMain.map(p => [p.lat, p.lng]), {
            color: 'blue',
            weight: 4
        }).addTo(map).bindPopup("Rute Utama");

        // Marker Titik Awal
        const startPoint = routeMain[0];
        if (startNode && startPoint) {
            L.marker([startPoint.lat, startPoint.lng])
                .addTo(map)
                .bindPopup("Titik Awal: " + startNode)
                .openPopup();
        }

        // Marker Titik Tujuan
        const endPoint = routeMain[routeMain.length - 1];
        if (endNode && endPoint) {
            L.marker([endPoint.lat, endPoint.lng])
                .addTo(map)
                .bindPopup("Titik Tujuan: " + endNode);
        }
    }

    if (routeAlt.length) {
        L.polyline(routeAlt.map(p => [p.lat, p.lng]), {
            color: 'red',
            weight: 3,
            // dashArray: '5, 10'
        }).addTo(map).bindPopup("Rute Alternatif");
    }

    // Tombol clear
    document.getElementById('btn-clear').addEventListener('click', function () {
        map.eachLayer(layer => {
            if (layer instanceof L.Polyline || layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });

        // Kirim AJAX untuk hapus session
        fetch("{{ route('clearRute') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            console.log(data.message);
            window.location.href = data.redirect;
        })
        .catch(err => {
            console.error("Gagal menghapus session:", err);
        });
    });
</script>

@endsection