<x-dash.layout>
    @slot('title')
        Dashboard
    @endslot
    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-4">
            <div class="card h-100">
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
        <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-4">
            <div class="card h-100">
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
        <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-4">
            <div class="card h-100">
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
        <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-4">
            <div class="card h-100">
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
        <div class="col-sm-6 col-md-4 col-xl-12 col-xxl-4">
            <div class="card shadow-none border" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    Grafik Surat
                </div>
                <div class="card-body p-2">
                    <div class="echart-bar-line-mixed-chart-example" style="min-height:350px"></div>
                </div>
            </div>
        </div>

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
                </div>
            </div>

        </div>
    </div>


</x-dash.layout>
