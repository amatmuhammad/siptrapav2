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
        <div class="col">
            <img src="{{ asset('assets2/images/pangan.png') }}" alt="image">
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
                            <div class="row">
                                <div class="col-3 mt-2 mb-2">
                                    <form action="">
                                        <select name="Pangan" id="pangan" class="form-control" py-5>
                                            <option value="">---Pilih Pangan---</option>
                                            <option value="">Beras</option>
                                            <option value="">Pisang</option>
                                            <option value="">Kelapa</option>
                                            <option value="">Kentang</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            
                            <canvas id="kabupaten"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        const warnaPangan = [
            '#f39c12', // Beras
            '#3498db', // Jagung
            '#95a5a6', // Kentang
            '#e30728', // Pisang
            '#7f8c8d', // Cabe
            '#fcba03', // Bawang Merah
            '#0362fc'  // Kelapa
        ];


       
        const ctxBar = document.getElementById('kabupaten').getContext('2d');

        const barData = {
            labels: [
                'Kendari',
                'Baubau',
                'Kolaka',
                'Muna',
                'Wakatobi',
                'Bombana',
                'Konawe Selatan',
                'Buton Utara'
            ],
            datasets: [{
                label: 'Total Produksi (ton)',
                data: [120, 85, 150, 95, 70, 110, 130, 90],
                backgroundColor: warnaPangan.slice(0,7),
                borderColor: warnaPangan.slice(0,7),
                borderWidth: 1
            }]
        };

        new Chart(ctxBar, {
            type: 'bar',
            data: barData,
            options: {
                responsive: true,
                // maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Produksi (Ton)'
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Produksi Pangan per Kabupaten di Sulawesi Tenggara'
                    }
                }
            }
        });
        


    </script>
@endsection