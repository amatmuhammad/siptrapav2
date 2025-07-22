@extends('layouts.main')

@section('judul','Persebaran Distributor')

@section('konten')
    <style>
        #map { 
            height: 480px;
            border-radius: 10px;
        
        }
    </style>

    <div class="container mt-5">
        <div class="card" style="border-radius: 10px;">
            <div class="card-body">
                <h4>Peta Persebaran Pangan</h4>
                
                <div id="map"></div>
            </div>

        </div>
    </div>

    {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-pz0mWxb+R7Vu//kUzxhpcJNf+dLseW6qZsHcU8wP4bM=" crossorigin=""></script> --}}

    <script>
        var map = L.map('map').setView([-4.009883696037205, 122.52053513424897], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([-4.009883696037205, 122.52053513424897])
            .addTo(map)
            .bindPopup('Lokasi Saya')
            .openPopup();
    </script>
@endsection
