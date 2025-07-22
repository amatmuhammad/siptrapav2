@extends('user.partials.mainuser')

@section('judul','Model Transportasi')

@section('konten')

    <style>
        #map { 
            height: 580px;
            border-radius: 10px;
        
        }
    </style>

{{-- jumbotron --}}
    <div class="jumbotron jumbotron-fluid mb-5">
        <div class="container text-center py-5">
            <h1 class="text-primary display-3">Model Transportasi</h1>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-circle px-3"></i>
                <p class="m-0">Model Transportasi</p>
            </div>
        </div>
    </div>
{{-- jumbotron --}}

<div class="container-fluid">
    <div class="container">
        <div class="text-center pb-2">
            <h1 class="text-primary"> Model Transportasi</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum nihil nostrum necessitatibus voluptatum, qui at nam veniam placeat quod animi exercitationem tenetur repellat iusto? Facere, consequuntur repellat repudiandae eius ab fuga excepturi incidunt veniam nulla sunt. Cupiditate iure mollitia amet?</p>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row mt-5">
            <div class="col">
                <div class="card mb-5 shadow rounded-3" style="border-radius: 10px;">
                    <div class="card-body">
                        <div id="successAlert" class="alert alert-success d-none" role="alert">
                            Cuaca Hari ini Bagus Silahkan Lalui Rute Yang Telah di buat dan Hati hati di jalan ^-^
                        </div>

                        <div id="warningAlert" class="alert alert-warning d-none" role="alert">
                            Cuaca Hari Ini agak Buruk di daerah ini Tolong berhati hati pastikan logistik anda dalam keadaan aman dalam perjalanan !!!
                        </div>

                        <div id="dangerAlert" class="alert alert-danger d-none" role="alert">
                            Cuaca Hari ini Buruk Tolong Perhatikan Logistik Anda dan pastikan aman Hati hati di jalan !!!
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-end mb-3">
                            <div class="form-group mb-0">
                                <select name="Alert" id="mySelect" class="form-control rounded">
                                    <option value="">---Pilih Kabupaten---</option>
                                    <option value="1">Kolaka</option>
                                    <option value="2">Kendari</option>
                                    <option value="3">Konawe</option>
                                </select>
                            </div>

                            <button type="button" class="btn btn-primary rounded ml-auto mt-2 mt-md-0" data-toggle="modal" data-target="#exampleModal">
                                Buat Model
                            </button>
                        </div>

                        <strong>Informasi Rute</strong>
                        <div class="jarak">Jarak (Km)               : <span id="distance"></span></div>
                        <div class="Waktu">Waktu Eksekusi Algoritma : <span id="execution-time"></span></div>
                        <div id="map"></div>
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
        <form id="ruteForm" method="POST" action="{{ route('cariRute') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Asal</label>
                    <input type="text" class="form-control" id="asalInput" name="start_node" placeholder="Masukkan Kabupaten Asal">
                </div>
                <div class="form-group">
                    <label>Tujuan</label>
                    <input type="text" class="form-control" id="tujuanInput" name="end_node" placeholder="Masukkan Kabupaten Tujuan">
                </div>
                <div class="form-group">
                    <label>Jenis Pangan</label>
                    <input type="text" class="form-control" id="asalInput" name="Jenis_pangan" placeholder="Masukkan Jenis pangan">
                </div>
                <div class="form-group">
                    <label>Volume</label>
                    <input type="text" class="form-control" id="tujuanInput" name="Volume" placeholder="Masukkan Volume (Ton)">
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


@if(isset($rute))
    <script>
        var rute = {!! json_encode($rute) !!};
    </script>
@endif

<script>
    var map = L.map('map').setView([-4.009, 122.520], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
    }).addTo(map);

    var currentRoute;

    document.getElementById('ruteForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const asal = document.getElementById('asalInput').value;
        const tujuan = document.getElementById('tujuanInput').value;

        fetch("{{ route('cariRute') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                start_node: asal,
                end_node: tujuan
            })
        })
        .then(response => {
            if (!response.ok) throw new Error("Rute tidak ditemukan");
            return response.json();
        })
        .then(data => {
            if (currentRoute) map.removeLayer(currentRoute);

            // const coords = data.map(d => [d.lat, d.lng]);
            // currentRoute = L.polyline(coords, { color: 'blue' }).addTo(map);
            // map.fitBounds(currentRoute.getBounds());

             const coords = data.rute.map(d => [d.lat, d.lng]);
            currentRoute = L.polyline(coords, { color: 'blue' }).addTo(map);
            map.fitBounds(currentRoute.getBounds());

            // Tampilkan jarak dan waktu
            document.getElementById("distance").textContent = `${data.totalDistance} km`;
            document.getElementById("execution-time").textContent = data.executionTime;

            $('#exampleModal').modal('hide');
        })
        .catch(err => alert(err.message));
    });


</script>


{{-- <script>
     var map = L.map('map').setView([-4.009883696037205, 122.52053513424897], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([-4.009883696037205, 122.52053513424897])
            .addTo(map)
            .bindPopup('Lokasi Saya')
            .openPopup();


    document.getElementById('mySelect').addEventListener('change', function () {
        const alerts = {
            1:document.getElementById('successAlert'),
            2:document.getElementById('warningAlert'),
            3:document.getElementById('dangerAlert'),
        };

        Object.values(alerts).forEach(alert => alert.classList.add('d-none'));

        const selected = this.value;
        if (alerts[selected]) {
            alerts[selected].classList.remove('d-none');
        }
    });

    let polylineLayer;

    document.getElementById('buatRuteBtn').addEventListener('click', function () {
        const asal = document.getElementById('asalInput').value;
        const tujuan = document.getElementById('tujuanInput').value;

        const formData = new FormData();
        formData.append('Asal', asal);
        formData.append('Tujuan', tujuan);

        fetch("{{ route('cariRute') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (polylineLayer) map.removeLayer(polylineLayer);
            const latlngs = data.map(coord => [coord.lat, coord.lng]);
            polylineLayer = L.polyline(latlngs, { color: 'blue' }).addTo(map);
            map.fitBounds(polylineLayer.getBounds());
            $('#exampleModal').modal('hide');
        })
        .catch(error => console.error('Gagal mendapatkan rute:', error));
    });
</script> --}}


@endsection