<x-dash.layout>
    @slot('title')
        Dashboard
    @endslot
    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-3 col-xl-3 col-xxl-3">
            <div class="card h-100" style="background-color: rgba(255, 99, 132, 0.2);">
                <div class="card-body">
                    <div class="d-flex d-sm-block justify-content-between">
                        <div class="mb-sm-4">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center icon-wrapper-sm shadow-primary-100"
                                    style="transform: rotate(-7.45deg);"><span
                                        class="fa-solid fa-envelope-open-text text-primary fs-7 z-1 ms-2"></span></div>
                                <p class="text-body-tertiary fs-9 mb-0 ms-2 mt-3">Jumlah Surat Masuk</p>
                            </div>
                            <p class="text-primary mt-2 fs-6 fw-bold mb-0 mb-sm-4">{{ $incomingLettersCount }} <span
                                    class="fs-8 text-body lh-lg">Surat</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3 col-xl-3 col-xxl-3">
            <div class="card h-100" style="background-color: rgba(153, 102, 255, 0.2);">
                <div class="card-body">
                    <div class="d-flex d-sm-block justify-content-between">
                        <div class="mb-sm-4">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center icon-wrapper-sm shadow-primary-100"
                                    style="transform: rotate(-7.45deg);"><span
                                        class="fa-solid fa-envelope-open text-primary fs-7 z-1 ms-2"></span></div>
                                <p class="text-body-tertiary fs-9 mb-0 ms-2 mt-3">Jumlah Surat Keluar</p>
                            </div>
                            <p class="text-primary mt-2 fs-6 fw-bold mb-0 mb-sm-4">{{ $outgoingLettersCount }} <span
                                    class="fs-8 text-body lh-lg">Surat</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-3 col-xxl-3">
            <div class="card h-100" style="background-color: rgba(255, 205, 86, 0.2);">
                <div class="card-body">
                    <div class="d-flex d-sm-block justify-content-between">
                        <div class="mb-sm-4">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center icon-wrapper-sm shadow-primary-100"
                                    style="transform: rotate(-7.45deg);"><span
                                        class="fa-solid fa-mail-bulk text-primary fs-7 z-1 ms-2"></span></div>
                                <p class="text-body-tertiary fs-9 mb-0 ms-2 mt-3">Jumlah Surat Rekomendasi</p>
                            </div>
                            <p class="text-primary mt-2 fs-6 fw-bold mb-0 mb-sm-4">0 <span
                                    class="fs-8 text-body lh-lg">Surat</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-3 col-xxl-3">
            <div class="card h-100" style="background-color: rgba(75, 192, 192, 0.2);">
                <div class="card-body">
                    <div class="d-flex d-sm-block justify-content-between">
                        <div class="mb-sm-4">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center icon-wrapper-sm shadow-primary-100"
                                    style="transform: rotate(-7.45deg);"><span
                                        class="fa-solid fa-mail-bulk text-primary fs-7 z-1 ms-2"></span></div>
                                <p class="text-body-tertiary fs-9 mb-0 ms-2 mt-3">Jumlah Berkas Tugas Dinas</p>
                            </div>
                            <p class="text-primary mt-2 fs-6 fw-bold mb-0 mb-sm-4">0 <span
                                    class="fs-8 text-body lh-lg">Surat</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-xl-6 col-xxl-6">
            <div class="card shadow-none border" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    Grafik Surat Masuk berdasarkan Bulan
                </div>
                <div class="card-body p-3">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-6 col-xl-6 col-xxl-6">
            <div class="card shadow-none border" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    Grafik Surat Keluar berdasarkan Bulan
                </div>
                <div class="card-body p-3">
                    <div>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-xl-6 col-xxl-6">
            <div class="card shadow-none border" data-component-card="data-component-card">
                <div class="card-header p-3 border-bottom bg-body">
                    Grafik Surat Masuk berdasarkan Sumber Surat
                </div>
                <div class="card-body p-3">
                    <div>
                        <canvas id="myChart3"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-xl-6 col-xxl-6">
            <div class="card shadow-none border" data-component-card="data-component-card">
                <div class="card-header p-3 border-bottom bg-body">
                    Grafik Surat Keluar berdasarkan Jenis Surat
                </div>
                <div class="card-body p-3">
                    <div>
                        <canvas id="myChart4"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-xl-6 col-xxl-6">
            <div class="card shadow-none border" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    Grafik Rekomendasi
                </div>
                <div class="card-body p-3">
                    <div>
                        <canvas id="myChart5"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-xl-6 col-xxl-6">
            <div class="card shadow-none border" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    Grafik Berkas Dinas
                </div>
                <div class="card-body p-3">
                    <div>
                        <canvas id="myChart6"></canvas>
                    </div>
                </div>
            </div>
        </div>

        @push('chart')
            <script>
                const ctx = document.getElementById('myChart');
                const ctx2 = document.getElementById('myChart2');
                const ctx3 = document.getElementById('myChart3');
                const ctx4 = document.getElementById('myChart4');
                const ctx5 = document.getElementById('myChart5');
                const ctx6 = document.getElementById('myChart6');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Surat',
                            data: [12, 19, 3, 5, 2, 3, 4, 5, 6, 7, 8, 9],
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                            ],
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Surat',
                            data: [12, 19, 3, 5, 2, 3, 4, 5, 6, 7, 8, 9],
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                            ],
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                new Chart(ctx3, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pusat', 'Provinsi', 'Bupati', 'Puskesmas', 'Dinas Terkait', 'LSM', 'Surat Kabar',
                            'Lainnya'
                        ],
                        datasets: [{
                            label: 'Surat',
                            data: [12, 19, 3, 5, 2, 3, 4, 5],
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)',
                                'rgb(255, 159, 64)',
                            ],
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                new Chart(ctx4, {
                    type: 'doughnut',
                    data: {
                        labels: ['Surat Undangan', 'Surat Dinas', 'Surat Panggilan', 'Surat Teguran', 'Surat Pernyataan',
                            'Surat Pernyataan Hukdis', 'Surat Perjanjian Damai', 'Surat Izin Magang', 'Surat SPMT',
                            'Lainnya'
                        ],
                        datasets: [{
                            label: 'Surat',
                            data: [12, 19, 3, 5, 2, 3, 4, 5, 6, 7],
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                            ],
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                new Chart(ctx5, {
                    type: 'doughnut',
                    data: {
                        labels: ['Surat Undangan', 'Surat Dinas', 'Surat Panggilan', 'Surat Teguran', 'Surat Pernyataan',
                            'Surat Pernyataan Hukdis', 'Surat Perjanjian Damai', 'Surat Izin Magang', 'Surat SPMT',
                            'Lainnya'
                        ],
                        datasets: [{
                            label: 'Surat',
                            data: [12, 19, 3, 5, 2, 3, 4, 5, 6, 7],
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                            ],
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    // This more specific font property overrides the global property
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });

                new Chart(ctx6, {
                    type: 'doughnut',
                    data: {
                        labels: ['Surat Tugas', 'Surat Perintah', 'SPPD', 'Nota Dinas'],
                        datasets: [{
                            label: 'Surat',
                            data: [12, 19, 3, 5],
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                            ],
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        @endpush

        <div class="col-12 col-md-6">
            <div class="card shadow-none border" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    Data e-Pelaporan
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 fw-bold">Bidang </p>
                        <p class="mb-0 fs-9">Total count <span class="fw-bold">257</span></p>
                    </div>
                    <hr class="bg-body-secondary mb-2 mt-2" />
                    <div class="d-flex align-items-center mb-1"><span
                            class="d-inline-block bg-info-light bullet-item me-2"></span>
                        <p class="mb-0 fw-semibold text-body lh-sm flex-1">P2P</p>
                        <h5 class="mb-0 text-body">78</h5>
                    </div>
                    <div class="d-flex align-items-center mb-1"><span
                            class="d-inline-block bg-warning-light bullet-item me-2"></span>
                        <p class="mb-0 fw-semibold text-body lh-sm flex-1">Kesmas</p>
                        <h5 class="mb-0 text-body">63</h5>
                    </div>
                    <div class="d-flex align-items-center mb-1"><span
                            class="d-inline-block bg-danger-light bullet-item me-2"></span>
                        <p class="mb-0 fw-semibold text-body lh-sm flex-1">SDMK</p>
                        <h5 class="mb-0 text-body">56</h5>
                    </div>
                    <div class="d-flex align-items-center mb-1"><span
                            class="d-inline-block bg-success-light bullet-item me-2"></span>
                        <p class="mb-0 fw-semibold text-body lh-sm flex-1">Keuangan</p>
                        <h5 class="mb-0 text-body">36</h5>
                    </div>
                    <button class="btn btn-outline-primary mt-5">Lihat detail<span
                            class="fas fa-angle-right ms-2 fs-10 text-center"></span></button>
                </div>
            </div>

        </div>
        <div class="col-12 col-md-6">
            <div class="card shadow-none border" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    Grafik Donat e-Pelaporan
                </div>
                <div class="card-body p-3">
                    <div class="echart-issue-chart" style="min-height:390px;width:100%"></div>
                    <div class="echart-basic-bar-chart-example" style="min-height:300px"></div>
                </div>
            </div>

        </div>
    </div>

    @push('footer')
        <script src="{{ asset('assets') }}/vendors/echarts/echarts.min.js"></script>
        <script src="{{ asset('assets') }}/vendors/echarts/echarts.min.js"></script>
        <script src="{{ asset('assets') }}/assets/js/crm-dashboard.js"></script>
    @endpush
</x-dash.layout>
