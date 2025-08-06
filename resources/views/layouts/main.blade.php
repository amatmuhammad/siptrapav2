<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('judul','Dashboard')</title>

    <meta name="description" content="" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Favicon -->
    {{-- <link rel="icon" type="image/x-icon" href="{{ asset('assets1/assets/img/favicon/favicon.ico') }}" /> --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets1/assets/vendor/fonts/iconify-icons.css') }}" />

    {{-- leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    {{-- chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome CDN tanpa integrity -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('assets1/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets1/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('assets1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- endbuild -->

    <link rel="stylesheet" href="{{ asset('assets1/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets1/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('assets1/assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
                <span class="text-primary">
                  <img src="{{ asset('images/LOGO UHO 1.png') }}" alt="Logo" style="height:35px;">
                </span>
              </span>
              <span class="app-brand-text demo menu-text fw-bold ms-2 text-warning" style="font-size: 30px;">| STRAPA</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
            </a>
          </div>

          <div class="menu-divider mt-0"></div>

          <div class="menu-inner-shadow"></div>

          {{-- sidebar --}}
          @include('admin.component.sidebar')
          
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

         @include('layouts.navbar')

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            @yield('konten')
            <!-- / Content -->

            <!-- Footer -->
            @include('layouts.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <script>
        // Simpan posisi scroll sebelum reload atau pindah halaman
        window.addEventListener("beforeunload", function () {
            localStorage.setItem("scrollPosition", window.scrollY);
        });

        // Setelah halaman dimuat, kembalikan posisi scroll
        window.addEventListener("load", function () {
            const scrollPos = localStorage.getItem("scrollPosition");
            if (scrollPos !== null) {
                window.scrollTo(0, parseInt(scrollPos));
            }
        });

          @if(session('success'))
              Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: "{{ session('success') }}",
                  confirmButtonColor: '#3085d6'
              });
          @endif

          @if(session('error'))
              Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "{{ session('error') }}",
                  confirmButtonColor: '#d33'
              });
          @endif

          @if($errors->any())
              let errorMsg = @json($errors->all());
              Swal.fire({
                  icon: 'error',
                  title: 'Validasi Gagal',
                  html: errorMsg.map(e => `<p>• ${e}</p>`).join(''),
                  confirmButtonColor: '#d33'
              });
          @endif
      </script>


      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

  

    <!-- Core JS -->

    <script src="{{ asset('assets1/assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('assets1/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets1/assets/vendor/js/bootstrap.js') }}"></script>

    <script src="{{ asset('assets1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets1/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets1/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->

    <script src="{{ asset('assets1/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets1/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
