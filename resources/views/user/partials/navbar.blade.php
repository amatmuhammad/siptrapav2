<div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.html" class="navbar-brand ml-lg-3">
                <h6 class="m-0 display-5 text-uppercase text-primary" ><img class="logo w-10 img-fluid py-2" src="{{ asset('assets2/img/LOGO.png') }}" style="width: 250px;"></img></h5>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3 navbar-auto" id="navbarCollapse">
                <div class="navbar-nav m-auto py-0">
                    <a href="{{ route('Beranda') }}" class="nav-item nav-link {{ Request::is('Beranda') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('Model') }}" class="nav-item nav-link {{ Request::is('Model-Transportasi') ? 'active' : '' }}">Model Transportasi</a>
                    <a href="{{ route('pangan') }}" class="nav-item nav-link {{ Request::is('Data-Pangan') ? 'active' : '' }}">Grafik Pangan</a>
                    <a href="{{ route('Distribusi') }}" class="nav-item nav-link {{ Request::is('Distribusi') ? 'active' : '' }}">Grafik Distribusi</a>
                    <a href="{{ route('Cuaca') }}" class="nav-item nav-link {{ Request::is('Prakiraan-Cuaca') ? 'active' : '' }}">Cuaca</a>
                </div>
                {{-- <a href="" class="btn btn-primary py-2 px-4 d-none d-lg-block">Get A Quote</a> --}}
            </div>
        </nav>
    </div>