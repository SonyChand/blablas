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
                            <select name="bulan" class="form-select" id="bulan" required>
                                <option value="" hidden>Pilih Bulan</option>
                                @php
                                    $namaBulan = [
                                        '1' => 'Januari',
                                        '2' => 'Februari',
                                        '3' => 'Maret',
                                        '4' => 'April',
                                        '5' => 'Mei',
                                        '6' => 'Juni',
                                        '7' => 'Juli',
                                        '8' => 'Agustus',
                                        '9' => 'September',
                                        '10' => 'Oktober',
                                        '11' => 'November',
                                        '12' => 'Desember',
                                    ];
                                @endphp
                                @foreach ($namaBulan as $bulan => $bulanItem)
                                    <option value="{{ $bulan }}"
                                        {{ old('bulan', session('bulan_spm')) == $bulan ? 'selected' : '' }}>
                                        {{ $bulanItem }}
                                    </option>
                                @endforeach
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
                            <h4 class="mb-0" autofocus>{{ $title }}<span
                                    class="fw-normal text-body-tertiary ms-3"></span></h4>
                        </div>
                        <div class="col col-md-auto">
                            <nav class="nav justify-content-end doc-tab-nav align-items-center" role="tablist">

                                @can('spm-create')
                                    <a class="btn btn-sm btn-primary" href="{{ route('spm.create') }}">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah
                                    </a>
                                @endcan
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive-sm scrollbar">
                        <table class="table table-bordered table-striped" id="yajra" width="100%">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>Kode</th>
                                    @foreach ($columnDetail as $column => $details)
                                        <th class="text-center">{{ ucwords($details['label']) }}</th>
                                    @endforeach
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
        <script src="{{ asset('vendor/larapex-charts/apexcharts.js') }}"></script>
        <script>
            let submit_method;

            $(document).ready(function() {
                tableYajra();
            });

            // datatable serverside
            function tableYajra() {
                $('#yajra').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('spm.serverside') }}",
                    columns: [{
                            data: 'kode',
                            name: 'kode',
                            orderable: true,
                            searchable: true
                        },
                        @foreach ($columnDetail as $column => $details)
                            {
                                data: '{{ $column }}',
                                name: '{{ $column }}'
                            },
                        @endforeach {
                            data: 'action',
                            name: 'action',
                        }
                    ]
                });
            };

            const deleteData = (e) => {
                let id = e.getAttribute('data-id');

                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Apakah anda ingin menghapus data ini?",
                    icon: "question",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showCloseButton: true
                }).then((result) => {
                    if (result.value) {

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: "/spm/" + id,
                            dataType: "json",
                            success: function(response) {
                                reloadTable();
                                toastr.success(response.message);
                            },
                            error: function(response) {
                                toastr.error(response.message);
                            }
                        });
                    }
                })
            }

            const editableColumns = [3, 4];
            let currentEditableRow = null;

            $('#yajra').on('click', '#btn-edit', function(e) {
                const dataId = $(this).data('id');
                const currentRow = $(this).closest('tr');

                if (currentEditableRow && currentEditableRow !== currentRow) {
                    resetEditableRow(currentEditableRow);
                }
                makeEditableRow(currentRow);
                currentEditableRow = currentRow;

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
                currentEditableRow.find('td:last').html(`
    <div class="btn-group mx-1">
        <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="${dataId}">
            <i class="fas fa-edit"></i>
        </button>
        <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(this)" data-id="${dataId}">
            <i class="fas fa-trash-alt"></i>
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

                        if (index === 3)
                            updatedData.dilayani = inputValue;
                        if (index === 4)
                            updatedData.terlayani = inputValue;
                    }
                })

                $.ajax({
                    url: "{{ route('spm.liveupdate') }}",
                    type: 'PUT',
                    data: {
                        id: dataId,
                        dilayani: updatedData.dilayani,
                        terlayani: updatedData.terlayani,
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
