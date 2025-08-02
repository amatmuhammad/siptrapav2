@extends('layouts.main')

@section('judul','Persebaran Distributor')

@section('konten')
<style>
    #map { 
        height: 480px;
        border-radius: 10px;
    
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

<div class="container mt-5">
    <div class="card" style="border-radius: 10px;">
        <div class="card-body">
            <h4><strong> Peta Matriks Distribusi </strong></h4>
            <div id="map"></div>
            <div id="legend" style="padding:10px;"></div>
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
