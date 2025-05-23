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
                            <select name="versi" class="form-select" id="versi" required>
                                <option value="" hidden>Pilih Versi</option>
                                <option value="1" {{ old('versi', session('versi_spm')) == 1 ? 'selected' : '' }}>
                                    Versi 1
                                </option>
                                <option value="2" {{ old('versi', session('versi_spm')) == 2 ? 'selected' : '' }}>
                                    Versi 2
                                </option>
                            </select>
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
                            <h4 class="mb-0" autofocus>StaPMinKes Ciamis tahun {{ $tahunSpm->tahun }} versi
                                {{ session('versi_spm', 1) }}
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
                                    <th>*</th>
                                    <th>Kode</th>
                                    <th class="text-center">Uraian SPM</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Jumlah Total Yang Harus Dilayani</th>
                                    <th class="text-center">Jumlah Total Yang Terlayani</th>
                                    <th class="text-center">Yang belum Terlayani</th>
                                    <th>%</th>
                                    <th>Aksi</th>
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
                    ajax: "{{ route('spm.serversidev1') }}",
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

            const editableColumns = [4, 5];
            let currentEditableRow = null;

            $('#yajra').on('click', '#btn-edit', function(e) {
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
                currentRow.find('td').each(function(index) {
                    const currentCell = $(this);
                    const currentText = currentCell.text().trim();
                    if (editableColumns.includes(index)) {
                        currentCell.html('<input type="text" class="form-control editable-input"  value="' +
                            currentText + '" />');
                    }
                })
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

            $('#yajra').on('click', '.btn-save', function(e) {
                const dataId = $(this).data('id');
                const currentRow = $(this).closest('tr');
                const updatedData = {};
                currentRow.find('td').each(function(index) {
                    if (editableColumns.includes(index)) {
                        const inputValue = $(this).find('input').val();

                        if (index === 4)
                            updatedData.total_dilayani = inputValue;
                        if (index === 5)
                            updatedData.total_terlayani = inputValue;
                    }
                })

                $.ajax({
                    url: "{{ route('spm.liveupdate') }}",
                    type: 'PUT',
                    data: {
                        id: dataId,
                        total_dilayani: updatedData.total_dilayani,
                        terlayani: updatedData.total_terlayani,
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
                })
            })
        </script>
    @endpush
</x-dash.layout>
