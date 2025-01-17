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
                            <h4 class="mb-0" autofocus>TABEL PERSENTASE PENCAPAIAN PENERIMA LAYANAN DASAR (80%) DAN
                                MUTU MINIMAL LAYANAN DASAR (20%)
                                <span class="fw-normal text-body-tertiary ms-3"></span>
                            </h4>
                        </div>
                        <div class="col col-md-auto">
                            <nav class="nav justify-content-end doc-tab-nav align-items-center" role="tablist">
                                <button type="button" class="btn btn-sm btn-outline-info"
                                    onclick="window.location.href='{{ route('spm.full') }}'">
                                    <i class="fas fa-expand me-2"></i>Versi Full Screen</button>
                            </nav>
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
                                    <th rowspan="2">Aksi</th>
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

            <div class="card d-print-none shadow-none border my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="mb-0" autofocus>TABEL ALOKASI ANGGARAN DAN REALISASI
                                <span class="fw-normal text-body-tertiary ms-3"></span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive-sm scrollbar">
                        <table class="table table-bordered table-striped" id="yajra2" width="100%"
                            style="font-size: 11pt;">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th rowspan="2">*</th>
                                    <th rowspan="2">Kode</th>
                                    <th rowspan="2" class="text-center">Uraian</th>
                                    <th rowspan="2">Satuan</th>
                                    <th rowspan="2">Alokasi Anggaran<br>(Rp.)</th>
                                    <th colspan="13" class="text-center">Realisasi (Rp.)</th>
                                    <th rowspan="2">Selisih</th>
                                    <th rowspan="2">%</th>
                                    <th rowspan="2">Aksi</th>
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
                                    <th>Jumlah</th>
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
                tableYajra2();
            });

            // datatable serverside
            function tableYajra() {
                $('#yajra').DataTable({
                    scrollY: '500px',
                    scrollCollapse: true,
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('spm.serverside') }}",
                    columns: [{
                            data: 'sub_id',
                            name: 'sub_id',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'kode',
                            name: 'kode',
                            render: function(data, type, row) {
                                return `<span class="kode-click" data-id="${row.id_sub}">${data}</span>`;
                            }
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
                        {
                            data: 'action',
                            name: 'action',
                        }
                    ],
                    lengthMenu: [10, 20, 50, 100, 200, 250], // Menyediakan opsi untuk 100, 200
                    pageLength: 250
                });
            };

            function tableYajra2() {
                $('#yajra2').DataTable({
                    scrollY: '500px',
                    scrollCollapse: true,
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('spm.serversideAnggaran') }}",
                    columns: [{
                            data: 'sub_id',
                            name: 'sub_id',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'kode',
                            name: 'kode',
                            render: function(data, type, row) {
                                return `<span class="kode-click" data-id="${row.id_sub}">${data}</span>`;
                            }
                        },
                        {
                            data: 'sub_layanan_id',
                            name: 'sub_layanan_id'
                        },
                        {
                            data: 'satuan',
                            name: 'satuan'
                        },
                        {
                            data: 'total_dilayani',
                            name: 'total_dilayani'
                        },
                        {
                            data: 'januari',
                            name: 'januari'
                        },
                        {
                            data: 'februari',
                            name: 'februari'
                        },
                        {
                            data: 'maret',
                            name: 'maret'
                        },
                        {
                            data: 'april',
                            name: 'april'
                        },
                        {
                            data: 'mei',
                            name: 'mei'
                        },
                        {
                            data: 'juni',
                            name: 'juni'
                        },
                        {
                            data: 'juli',
                            name: 'juli'
                        },
                        {
                            data: 'agustus',
                            name: 'agustus'
                        },
                        {
                            data: 'september',
                            name: 'september'
                        },
                        {
                            data: 'oktober',
                            name: 'oktober'
                        },
                        {
                            data: 'november',
                            name: 'november'
                        },
                        {
                            data: 'desember',
                            name: 'desember'
                        },
                        {
                            data: 'total_terlayani',
                            name: 'total_terlayani'
                        },
                        {
                            data: 'belum_terlayani',
                            name: 'belum_terlayani'
                        },
                        {
                            data: 'total_pencapaian',
                            name: 'total_pencapaian'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ],
                    lengthMenu: [10, 20, 50, 100, 200, 250],
                    pageLength: 250
                });
            };

            $('#yajra').on('click', '.kode-click', function() {
                const subLayananId = $(this).data('id');
                const currentRow = $(this).closest('tr');

                // Close any other expanded rows
                $('#yajra tbody tr.details-row').each(function() {
                    if ($(this).prev().hasClass('bg-loud-warning')) {
                        $(this).prev().removeClass(
                            'bg-loud-warning'); // Remove yellow background from the parent row
                        $(this).remove(); // Remove the details row
                    }
                });

                // Check if the details row already exists
                if (currentRow.next().hasClass('details-row')) {
                    // If it exists, check if it is currently visible
                    if (currentRow.next().is(':visible')) {
                        // If it is visible, hide it and remove the bg-loud-warning class
                        currentRow.next().hide(); // Hide the details row
                        currentRow.removeClass('bg-loud-warning'); // Remove the yellow background
                    } else {
                        // If it is not visible, show it and add the bg-loud-warning class
                        currentRow.next().show(); // Show the details row
                        currentRow.addClass('bg-loud-warning'); // Add the yellow background
                    }
                } else {
                    // Fetch the related data
                    $.ajax({
                        url: `/e-spm/spm/get-sublayanan/${subLayananId}`, // Adjust this URL to your API endpoint
                        method: 'GET',
                        success: function(response) {
                            // Create a new row for details
                            const detailsRow = `
 <tr class="details-row">
 <td colspan="21">
 <table class="table table-bordered table-striped">
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
 <th rowspan="2">Aksi</th>
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
 ${response.subLayanan.map((item, index) => `
                                                                                                                                                                                                                                                                                                                 <tr class="text-center">
                                                                                                                                                                                                                                                                                                                 <td class="text-center">
                                                                                                                                                                                                                                                                                                                 <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="${item.id}">
                                                                                                                                                                                                                                                                                                                 <i class="fas fa-edit"></i>
                                                                                                                                                                                                                                                                                                                 </button>
                                                                                                                                                                                                                                                                                                                 </td>
                                                                                                                                                                                                                                                                                                                 <td>${item.kode}</td>
                                                                                                                                                                                                                                                                                                                 <td class="text-start">${index + 1}. ${item.uraian}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.satuan}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.total_dilayani}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_januari}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_februari}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_maret}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_april}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_mei}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_juni}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_juli}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_agustus}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_september}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_oktober}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_november}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.terlayani_desember}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.total_terlayani}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.belum_terlayani}</td>
                                                                                                                                                                                                                                                                                                                 <td>${item.total_pencapaian}</td>
                                                                                                                                                                                                                                                                                                                 <td>
                                                                                                                                                                                                                                                                                                                 <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="${item.id}">
                                                                                                                                                                                                                                                                                                                 <i class="fas fa-edit"></i>
                                                                                                                                                                                                                                                                                                                 </button>
                                                                                                                                                                                                                                                                                                                 </td>
                                                                                                                                                                                                                                                                                                                 </tr>
                                                                                                                                                                                                                                                                                                                 `).join('')}
 </tbody>
 </table>
 </td>
 </tr>
 `;
                            currentRow.after(detailsRow); // Insert the details row after the current row
                            currentRow.addClass(
                                'bg-loud-warning'); // Add the yellow background to the parent row
                        },
                        error: function() {
                            alert('Error fetching data');
                        }
                    });
                }
            });

            const editableColumns = [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
            let currentEditableRow = null;

            $('#yajra, #yajra2').on('click', '#btn-edit', function(e) {
                const dataId = $(this).data('id');
                const currentRow = $(this).closest('tr');

                if (currentEditableRow && currentEditableRow !== currentRow) {
                    resetEditableRow(currentEditableRow);
                }
                makeEditableRow(currentRow);
                currentEditableRow = currentRow;

                currentRow.find('td:first').html(
                    '<button class="btn btn-sm btn-primary btn-save" type="button" data-id="' + dataId +
                    '"><i class="fas fa-check"></i></button>'
                )

                currentRow.find('td:last').html(
                    '<button class="btn btn-sm btn-primary btn-save" type="button" data-id="' + dataId +
                    '"><i class="fas fa-check"></i></button>'
                )

            });


            function makeEditableRow(currentRow) {
                const today = new Date();
                const currentMonth = today.getMonth(); // 0-11 (0 = Januari)
                const currentYear = today.getFullYear();
                const spmYear = {{ $tahunSpm->tahun }};
                const currentDate = today.getDate();

                currentRow.find('td').each(function(index) {
                    const currentCell = $(this);
                    const currentText = currentCell.text().trim();
                    const numericText = currentText.replace(/[^0-9]/g, '');

                    if (editableColumns.includes(index)) {
                        // Cek apakah bulan dan tahun sesuai
                        const monthIndex = index - 5; // Indeks bulan (5 = Januari, 6 = Februari, dst.)
                        if (monthIndex >= 0 && monthIndex < 12) {
                            if (currentYear === spmYear && currentMonth === monthIndex && currentDate >=
                                {{ $periodeSpm->periode_awal ?? 0 }} && currentDate <=
                                {{ $periodeSpm->periode_akhir ?? 0 }}) {
                                currentCell.html('<input type="text" class="form-control editable-input" value="' +
                                    numericText + '" />');
                            } else {
                                currentCell.html('<input type="text" class="form-control editable-input" value="' +
                                    numericText + '" disabled />');
                            }
                        } else {
                            currentCell.html('<input type="text" class="form-control editable-input" value="' +
                                numericText + '" />');
                        }
                    }
                });
            }


            function resetEditableRow(currentEditableRow) {
                currentEditableRow.find('td').each(function(index) {
                    const currentCell = $(this);
                    if (editableColumns.includes(index)) {
                        const currentValue = currentCell.find('input').val();
                        currentCell.html(`${currentValue}`);
                    }
                })

                const dataId = currentEditableRow.find('.btn-save').data('id');
                currentEditableRow.find('td:first').html(`
 <div class="btn-group mx-1">
 <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="${dataId}">
 <i class="fas fa-edit"></i>
 </button>
 </div>
`);
                currentEditableRow.find('td:last').html(`
 <div class="btn-group mx-1">
 <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="${dataId}">
 <i class="fas fa-edit"></i>
 </button>
 </div>
`);
            }

            $('#yajra, #yajra2').on('click', '.btn-save', function(e) {
                const dataId = $(this).data('id');
                const currentRow = $(this).closest('tr');
                const updatedData = {};

                // Mendapatkan tanggal saat ini
                const today = new Date();
                const currentYear = today.getFullYear();
                const currentMonth = today.getMonth(); // 0 = Januari, 1 = Februari, ..., 11 = Desember
                const currentDate = today.getDate();

                currentRow.find('td').each(function(index) {
                    if (editableColumns.includes(index)) {
                        const inputValue = $(this).find('input').val();

                        // Validasi untuk bulan yang sesuai
                        if (currentDate >= {{ $periodeSpm->periode_awal ?? 0 }} && currentDate <=
                            {{ $periodeSpm->periode_akhir ?? 0 }}) {
                            if (index === 5 && currentMonth === 0) // Januari
                                updatedData.januari = inputValue;
                            if (index === 6 && currentMonth === 1) // Februari
                                updatedData.februari = inputValue;
                            if (index === 7 && currentMonth === 2) // Maret
                                updatedData.maret = inputValue;
                            if (index === 8 && currentMonth === 3) // April
                                updatedData.april = inputValue;
                            if (index === 9 && currentMonth === 4) // Mei
                                updatedData.mei = inputValue;
                            if (index === 10 && currentMonth === 5) // Juni
                                updatedData.juni = inputValue;
                            if (index === 11 && currentMonth === 6) // Juli
                                updatedData.juli = inputValue;
                            if (index === 12 && currentMonth === 7) // Agustus
                                updatedData.agustus = inputValue;
                            if (index === 13 && currentMonth === 8) // September
                                updatedData.september = inputValue;
                            if (index === 14 && currentMonth === 9) // Oktober
                                updatedData.oktober = inputValue;
                            if (index === 15 && currentMonth === 10) // November
                                updatedData.november = inputValue;
                            if (index === 16 && currentMonth === 11) // Desember
                                updatedData.desember = inputValue;
                        } else {
                            // Jika tanggal tidak dalam rentang yang diizinkan, tampilkan pesan kesalahan
                            toastr.error(
                                'Anda hanya dapat mengedit data dari tanggal {{ $periodeSpm->periode_awal ?? 0 }} hingga {{ $periodeSpm->periode_akhir ?? 0 }} pada bulan ini.'
                            );
                            return; // Hentikan eksekusi lebih lanjut
                        }
                    }
                });

                // Lanjutkan dengan AJAX jika semua validasi berhasil
                $.ajax({
                    url: "{{ route('spm.liveupdate') }}",
                    type: 'PUT',
                    data: {
                        id: dataId,
                        total_dilayani: updatedData.total_dilayani,
                        terlayani_januari: updatedData.januari,
                        terlayani_februari: updatedData.februari,
                        terlayani_maret: updatedData.maret,
                        terlayani_april: updatedData.april,
                        terlayani_mei: updatedData.mei,
                        terlayani_juni: updatedData.juni,
                        terlayani_juli: updatedData.juli,
                        terlayani_agustus: updatedData.agustus,
                        terlayani_september: updatedData.september,
                        terlayani_oktober: updatedData.oktober,
                        terlayani_november: updatedData.november,
                        terlayani_desember: updatedData.desember,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        reloadTable();
                        toastr.success(response.message);
                    },
                    error: function(response) {
                        console.log(response);
                        toastr.error(response.responseText);
                    }
                });
            });

            function getMonthName(index) {
                const monthNames = [
                    'januari', 'februari', 'maret', 'april', 'mei', 'juni',
                    'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
                ];
                return monthNames[index];
            }
        </script>
    @endpush
</x-dash.layout>
