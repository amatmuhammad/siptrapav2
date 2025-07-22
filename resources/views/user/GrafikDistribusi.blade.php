@extends('user.partials.mainuser')

@section('judul','Grafik Distribusi')

@section('konten')

    <style>
        #map { 
            height: 480px;
            border-radius: 10px;
            width: 100%;
        
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

        <div id="customCardCarousel" class="carousel slide mt-5 mb-5" data-ride="carousel">
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

                <!-- Navigasi -->
                {{-- <a class="carousel-control-prev" href="#customCardCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#customCardCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a> --}}
        </div>
    </div>
    
<div class="container-fluid bg-secondary" >
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="text-center">
                    <h2 class="text-primary mt-5">Matriks Distribusi Pangan</h2>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam voluptates doloremque eum ipsa, nam reiciendis atque deserunt vel alias tenetur dolorum nihil dignissimos ea dolorem ad libero omnis quisquam cum minima obcaecati nostrum. Similique vero pariatur officiis quod voluptatum explicabo dolorum nesciunt laboriosam laborum architecto corporis eveniet id maxime fugit, magnam magni eligendi illum consectetur dolorem enim? At pariatur architecto excepturi tempore nam quia delectus suscipit harum ab magni provident, quod aliquid mollitia neque, voluptatibus fugit exercitationem iure. Odio necessitatibus vel quasi excepturi eum! Ad cupiditate dignissimos similique aut corrupti soluta, accusamus quidem beatae. Totam aspernatur cumque quia explicabo eius.</p>
                </div>
            </div>
            <div class="col-8">
                <div class="card mt-5 mb-5 shadow" style="border-radius: 20px;">
                    <div class="card-body">
                        <h4>Matriks Distribusi</h4>
                        <div class="map" id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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