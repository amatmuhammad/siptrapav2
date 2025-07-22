@extends('layouts.main')

@section('konten')

   <div class="container-xl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-12 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-start row">
                      <div class="col-md-6">
                        <div class="card-body">
                          <h3 class="card-title text-warning mb-3 mt-4">Selamat Datang Admin</h3>
                          <p class="mb-6">
                            Kamu Dapat Memantau Data Komoditas Pangan Dari Sini.<br />Ayok Mulai Sadar Akan Kualitas Pangan
                          </p>

                          {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> --}}
                        </div>
                      </div>
                      <div class="col-md-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                          <img
                            src="{{ asset('assets1/assets/img/illustrations/Vector.png') }}"
                            height="175"
                            alt="View Badge User" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                

                {{-- chart --}}
                <div class="chart">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="mb-4">Grafik Data Pangan Setiap Kabupaten</h4>
                      <div class="row">
                        <div class="col-12 ms-auto">
                          <div class="dropdown">
                            <button class="btn btn-outline-warning dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                              Filter Data
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li><a class="dropdown-item" href="#">Action</a></li>
                              <li><a class="dropdown-item" href="#">Another action</a></li>
                              <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <canvas class="cuaca" id="cuaca"></canvas>
                    </div>
                  </div>
                </div>
              
                {{-- chart --}}
                {{-- card --}}
              {{-- <div class="row g-6 mb-6">
                <div class="col-sm-6 col-xl-4">
                  <div class="card text-bg-primary">
                    <div class="card-body">
                      <h5 class="card-title text-white">Komoditas Padi/Beras</h5>
                      <p class="card-text">Some quick example text to build on the card title and make up.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xl-4">
                  <div class="card text-bg-secondary">
                    <div class="card-body">
                      <h5 class="card-title text-white">Komoditas Jagung</h5>
                      <p class="card-text">Some quick example text to build on the card title and make up.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                  <div class="card bg-success text-white">
                    <div class="card-body">
                      <h5 class="card-title text-white">Komoditas Gula </h5>
                      <p class="card-text">Some quick example text to build on the card title and make up.</p>
                    </div>
                  </div>
                </div>
               
              </div> --}}
                {{-- endcard --}}
              </div>
            </div>


            <script>
              const labels = ['Bombana','Buton','Kolaka','Muna','Konawe','Wakatobi','Buton Selatan','Buton Utara', 'Konawe Selatan','Konawe Kepulauan','Muna Barat', 'Kolaka Timur'];
                const data = {
                  labels: labels,
                  datasets: [{
                    label: 'Pangan (Ton)',
                    data: [65, 59, 80, 81, 56, 55, 40, 30, 20, 47, 90, 45],
                    backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(255, 159, 64, 0.2)',
                      'rgba(255, 205, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                      'rgb(255, 99, 132)',
                      'rgb(255, 159, 64)',
                      'rgb(255, 205, 86)',
                      'rgb(75, 192, 192)',
                      'rgb(54, 162, 235)',
                      'rgb(153, 102, 255)',
                      'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                  }]
                };
                const config = {
                  type: 'bar',
                  data: data,
                  options: {
                    plugins: {
                      // legend: {
                      //   display: false
                      // }
                    },
                    scales: {
                      y: {
                        beginAtZero: true
                      }
                    }
                  },
                };

                new Chart(document.getElementById('cuaca'),config);
            </script>



@endsection