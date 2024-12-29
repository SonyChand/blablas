<x-dash.layout>
    @push('header')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    @endpush
    @slot('title')
        {{ $title }}
    @endslot

    <div class="mb-9">
        <div id="{{ str_replace(' ', '', $title) }}Data">
            <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">{{ $title }}</h2>
                </div>
                <div class="col-auto">
                    <form action="{{ route('spm.tahunspm') }}" method="POST" class="needs-validation" novalidate
                        onsubmit="showLoader()">
                        @csrf
                        <div class="input-group mb-3">
                            <select name="tahun" class="form-select" id="tahun" required>
                                <option value="" hidden>Pilih Tahun</option>
                                @foreach ($tahuns as $tahunItem)
                                    <option value="{{ $tahunItem->id }}"
                                        {{ old('tahun', session('tahun_spm')) == $tahunItem->id ? 'selected' : '' }}>
                                        {{ $tahunItem->tahun }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Pilih</button>
                        </div>

                    </form>
                </div>
            </div>


            <div class="card d-print-none shadow-none border my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="mb-0" autofocus>{{ $title }} tahun {{ $tahunSpm->tahun }}<span
                                    class="fw-normal text-body-tertiary ms-3"></span></h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive-sm scrollbar">
                        <table class="table table-bordered table-striped" id="yajra" width="100%"
                            style="font-size: 11pt;">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th rowspan="2">*</th>
                                    <th rowspan="2">Kode</th>
                                    <th rowspan="2" class="text-center">Uraian</th>
                                    <th rowspan="2">Satuan</th>
                                    <th rowspan="2">Total Dilayani</th>
                                    <th colspan="13" class="text-center">Jumlah yang Terlayani</th>
                                    <th rowspan="2">Yang belum Terlayani</th>
                                    <th rowspan="2">%</th>
                                </tr>
                                <tr class="text-center">
                                    <th><span class="mx-2">Januari</span></th>
                                    <th><span class="mx-2">Februari</span></th>
                                    <th><span class="mx-2">Maret</span></th>
                                    <th><span class="mx-2">April</span></th>
                                    <th><span class="mx-2">Mei</span></th>
                                    <th><span class="mx-2">Juni</span></th>
                                    <th><span class="mx-2">Juli</span></th>
                                    <th><span class="mx-2">Agustus</span></th>
                                    <th><span class="mx-2">September</span></th>
                                    <th><span class="mx-2">Oktober</span></th>
                                    <th><span class="mx-2">November</span></th>
                                    <th><span class="mx-2">Desember</span></th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('footer')
        <script>
            let submit_method;

            $(document).ready(function() {
                tableYajra();
            });

            // datatable serverside
            function tableYajra() {
                $('#yajra').DataTable({
                    scrollY: '500px',
                    scrollCollapse: true,
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('spm.rekapServerside') }}",
                    columns: [{
                            data: 'sub_id',
                            name: 'sub_id',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'kode',
                            name: 'kode'
                        },
                        {
                            data: 'sub_layanan_id',
                            name: 'sub_layanan_id'
                        },
                        {
                            data: 'satuan',
                            name: 'satuan',
                        },
                        {
                            data: 'total_dilayani',
                            name: 'total_dilayani',
                        },
                        {
                            data: 'januari',
                            name: 'januari',
                        },
                        {
                            data: 'februari',
                            name: 'februari',
                        },
                        {
                            data: 'maret',
                            name: 'maret',
                        },
                        {
                            data: 'april',
                            name: 'april',
                        },
                        {
                            data: 'mei',
                            name: 'mei',
                        },
                        {
                            data: 'juni',
                            name: 'juni',
                        },
                        {
                            data: 'juli',
                            name: 'juli',
                        },
                        {
                            data: 'agustus',
                            name: 'agustus',
                        },
                        {
                            data: 'september',
                            name: 'september',
                        },
                        {
                            data: 'oktober',
                            name: 'oktober',
                        },
                        {
                            data: 'november',
                            name: 'november',
                        },
                        {
                            data: 'desember',
                            name: 'desember',
                        },
                        {
                            data: 'total_terlayani',
                            name: 'total_terlayani',
                        },
                        {
                            data: 'belum_terlayani',
                            name: 'belum_terlayani',
                        },
                        {
                            data: 'total_pencapaian',
                            name: 'total_pencapaian',
                        },
                    ],
                    lengthMenu: [10, 20, 50, 100, 200], // Menyediakan opsi untuk 100, 200
                    pageLength: 200
                });
            };
        </script>
    @endpush
</x-dash.layout>
