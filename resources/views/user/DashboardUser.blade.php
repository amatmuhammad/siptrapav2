@extends('user.partials.mainuser')

@section('konten')

{{-- jumbotron --}}
<div class="jumbotron jumbotron-fluid mb-5">
    <div class="container text-center py-5">
        <h1 class="text-primary display-4 mb-4">Pangan Bergerak Cepat</h1>
        <h1 class="text-white display-3 mb-5">Negeri Bergerak Maju</h1>
    </div>
</div>
{{-- jumbotron --}}

 <!-- About Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 pb-4 pb-lg-0">
                <img class="img-fluid w-100" src="{{ asset('assets2/img/about.jpg') }}" alt="">
                <div class="bg-primary text-center p-4">
                    <h3 class="m-0  text-white">Transportasi Pangan</h3>
                </div>
            </div>
            <div class="col-lg-7">
                <h6 class="text-primary text-uppercase font-weight-bold">About Us</h6>
                <h1 class="mb-4">Sistem Pemodelan Transportasi Pangan</h1>
                <p class="mb-4" style="text-align: justify;">Sistem pemodelan transportasi pangan adalah kerangka atau pendekatan terstruktur yang digunakan untuk merencanakan, mengelola, dan mengoptimalkan distribusi pangan dari titik produksi (seperti pertanian atau peternakan) ke titik konsumsi (seperti pasar, industri, atau rumah tangga).</p>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<div class="container-fluid pt-5">
    <div class="container">
        <div class="text-center pb-2">
            <h6 class="text-primary text-uppercase font-weight-bold">Research Team</h6>
            <h1 class="mb-4">Meet Our Research Team</h1>
        </div>
        <div class="row">
            
            <div class="col-lg-4 col-md-6">
                <div class="team card position-relative overflow-hidden border-0 mb-5">
                    <img class="card-img-top" src="{{ asset('assets2/images/prof.adris.png') }}" alt="">
                    <div class="card-body text-center p-0">
                        <div class="team-text d-flex flex-column justify-content-center bg-secondary">
                            <h5 class="font-weight-bold">Prof. Dr. Adris Ade Putra, ST,MT. IPM, ASEAN Eng</h5>
                            <span>Leader Researcher</span>
                        </div>
                        <div class="team-social d-flex align-items-center justify-content-center bg-primary">
                            <h5>Wakil Dekan III Fakultas Teknik UHO</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="team card position-relative overflow-hidden border-0 mb-5">
                    <img class="card-img-top" src="{{ asset('assets2/images/bujenny.png') }}" alt="">
                    <div class="card-body text-center p-0">
                        <div class="team-text d-flex flex-column justify-content-center bg-secondary">
                            <h5 class="font-weight-bold">Dr. Jenny Delly, ST., MT</h5>
                            <span>Research Team Members</span>
                        </div>
                        <div class="team-social d-flex align-items-center justify-content-center bg-primary">
                            <h5>Dosen Fakultas Teknik UHO</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="team card position-relative overflow-hidden border-0 mb-5">
                    <img class="card-img-top" src="{{ asset('assets2/images/pak asa.png') }}" alt="gambar">
                    <div class="card-body text-center p-0">
                        <div class="team-text d-flex flex-column justify-content-center bg-secondary">
                            <h5 class="font-weight-bold">Asa Hari Wibowo, S.T., M.Eng.</h5>
                            <span>Research Team Members</span>
                        </div>
                        <div class="team-social d-flex align-items-center justify-content-center bg-primary">
                            <h5>Dosen Fakultas Teknik UHO</h5>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!--  Quote Request Start -->
<div class="container-fluid bg-secondary my-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 py-5 py-lg-0">
                <h1 class="mb-4 mt-3 text-primary">Wilayah Cakupan</h1>
                <h6 class="text-primary text-uppercase font-weight-bold"><hr style="border: 3px solid rgba(255, 119, 0, 0.952); "></h6>
                <p class="mb-2" style="text-align: justify;">Sistem ini diterapkan secara menyeluruh di wilayah Provinsi Sulawesi Tenggara, mencakup berbagai kabupaten dan kota yang menjadi titik strategis dalam rantai distribusi pangan. Dengan mempertimbangkan kondisi geografis, infrastruktur transportasi, serta dinamika pasokan dan permintaan pangan, wilayah ini dipilih sebagai lokasi implementasi utama. Cakupan sistem melibatkan wilayah daratan dan kepulauan, yang memungkinkan pemantauan dan pemodelan jalur distribusi pangan secara realtime, akurat, dan adaptif terhadap perubahan kondisi lapangan. Pendekatan ini bertujuan untuk meningkatkan efisiensi, ketahanan, dan kecepatan distribusi pangan di seluruh kawasan Sulawesi Tenggara.</p>
                <div class="row">
                    <div class="col-sm-4">
                        <h1 class="text-primary mb-2" data-toggle="counter-up">{{ $data }}</h1>
                        <h6 class="font-weight-bold mb-4">Wilayah Kabupaten</h6>
                    </div>
                    <div class="col-sm-4">
                        <h1 class="text-primary mb-2" data-toggle="counter-up">{{ $produsen }}</h1>
                        <h6 class="font-weight-bold mb-4">Distributor</h6>
                    </div>
                    <div class="col-sm-4">
                        <h1 class="text-primary mb-2" data-toggle="counter-up">{{ $nama_pangan }}</h1>
                        <h6 class="font-weight-bold mb-4">Komoditi Pangan</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="bg-primary py-5 px-4 px-sm-5">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                            <img src="{{ asset('assets2/images/muna.png') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                            <img src="{{ asset('assets2/images/wakatobi.png') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                            <img src="{{ asset('assets2/images/Baubau.png') }}" class="d-block w-100" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quote Request Start -->


<!-- Features Start -->
<div class="container-fluid mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <img class="img-fluid w-100 shadow" src="{{ asset('assets2/img/feature.jpg') }}" alt="">
            </div>
            <div class="col-lg-7 py-5 py-lg-0">
                {{-- <h6 class="text-primary text-uppercase font-weight-bold">Why Choose Us</h6> --}}
                <h1 class="mb-4">Efficient, Reliable, and Real-Time Transportation Solutions</h1>
                <p class="mb-4" style="text-align: justify;">Kami menawarkan solusi transportasi yang efisien dan adaptif melalui sistem pemodelan berbasis teknologi terkini. Dengan dukungan informasi cuaca yang aktual dan real-time, sistem kami mampu memberikan estimasi waktu dan jarak yang lebih akurat. Selain itu, kami menyediakan jalur alternatif secara dinamis untuk menghindari hambatan seperti cuaca buruk atau kondisi jalan yang tidak terduga, sehingga pengiriman dapat dilakukan dengan lebih cepat, aman, dan tepat sasaran.</p>
                <ul class="list-inline">
                    <li><h6><i class="far fa-dot-circle text-primary mr-3"></i>Dynamic Alternative Paths</h6>
                    <li><h6><i class="far fa-dot-circle text-primary mr-3"></i>Real-Time Weather Integration</h6></li>
                    <li><h6><i class="far fa-dot-circle text-primary mr-3"></i>Accurate Time & Distance Estimation</h6></li>
                </ul>
                {{-- <a href="" class="btn btn-primary mt-3 py-2 px-4">Learn More</a> --}}
            </div>
        </div>
    </div>
</div>
<!-- Features End -->

@endsection