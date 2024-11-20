<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="mb-9">
        <div id="officialTaskFileSummary"
            data-list='{"valueNames":["id","letter_type", "letter_number", "letter_reference", "letter_date", "assign", "to_implement", "letter_closing", "letter_creation_date", "signed_by", "operator_name"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">Daftar Official Task Files<span class="fw-normal text-body-tertiary ms-3"></span>
                    </h2>
                </div>
            </div>
            <form method="POST" action="{{ route('official-task-files.bulkDestroy') }}" id="bulk-delete-form">
                @csrf
                @method('DELETE')
                <div class="row g-3 justify-content-between align-items-end mb-4">
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex align-items-center">
                            @can('official_task_file-create')
                                <div class="mt-3 mx-2">
                                    <div class="btn-group">
                                        <a href="{{ route('official-task-files.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-plus me-2"></i>Tambah Official Task File
                                        </a>
                                    </div>
                                </div>
                            @endcan
                            <div class="mt-3">
                                <button type="submit" class="btn btn-danger btn-sm" id="delete-selected"
                                    onclick="return confirm('Apakah anda yakin?')" disabled>
                                    <span class="fas fa-trash me-2"></span>Hapus yang dipilih
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-auto">
                        <div class="search-box me-3">
                            <form class="position-relative">
                                <input class="form-control search-input search" type="search"
                                    placeholder="Cari official task file" aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive scrollbar">
                    <table class="table fs-9 mb-0 border-top border-translucent">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width:2%;">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="sort ps-3" scope="col" data-sort="id" style="width:6%;">No</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="letter_type">
                                    Jenis Surat</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="letter_number">
                                    Nomor Surat</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="letter_reference">
                                    Referensi Surat</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="letter_date">
                                    Tanggal Surat</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="assign">
                                    Penugasan</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="to_implement">
                                    Pelaksanaan</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="letter_closing">
                                    Penutup Surat</th>
                                <th class="sort white-space-nowrap ps-0" scope="col"
                                    data-sort="letter_creation_date">
                                    Tanggal Pembuatan Surat</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="signed_by">
                                    Ditandatangani Oleh</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="operator_name">Nama
                                    Operator</th>
                                @canany(['official_task_file-edit', 'official_task_file-delete',
                                    'official_task_file-download'])
                                    <th class="sort text-end" scope="col"></th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="list" id="official-task-file-list-table-body">
                            @php $i = 0; @endphp
                            @foreach ($officialTaskFiles as $officialTaskFile)
                                <tr class="position-static">
                                    <td class="text-center time white-space-nowrap ps-0 id py-4">
                                        <input type="checkbox" name="officialTaskFileIds[]"
                                            value="{{ $officialTaskFile->id }}" class="select-item">
                                    </td>
                                    <td class="text-center time white-space-nowrap ps-0 id py-4">{{ ++$i }}
                                    </td>
                                    <td class="time white-space-nowrap ps-0 letter_type py-4">
                                        {{ $officialTaskFile->letter_type }}</td>
                                    <td class="time white-space-nowrap ps-0 letter_number py-4">
                                        {{ $officialTaskFile->letter_number }}</td>
                                    <td class="time white-space-nowrap ps-0 letter_reference py-4">
                                        {{ $officialTaskFile->letter_reference }}</td>
                                    <td class="time white-space-nowrap ps-0 letter_date py-4">
                                        {{ $officialTaskFile->letter_date->format('d-m-Y') }}</td>
                                    <td class="time white-space-nowrap ps-0 assign py-4">
                                        {{ $officialTaskFile->assign }}</td>
                                    <td class="time white-space-nowrap ps-0 to_implement py-4">
                                        {{ $officialTaskFile->to_implement }}</td>
                                    <td class="time white-space-nowrap ps-0 letter_closing py-4">
                                        {{ $officialTaskFile->letter_closing }}</td>
                                    <td class="time white-space-nowrap ps-0 letter_creation_date py-4">
                                        {{ $officialTaskFile->letter_creation_date->format('d-m-Y') }}</td>
                                    <td class="time white-space-nowrap ps-0 signed_by py-4">
                                        {{ $officialTaskFile->signed_by }}</td>
                                    <td class="time white-space-nowrap ps-0 operator_name py-4">
                                        {{ $officialTaskFile->operator_name }}</td>
                                    @canany(['official_task_file-edit', 'official_task_file-delete',
                                        'official_task_file-download'])
                                        <td class="text-end white-space-nowrap pe-0 action">
                                            <div class="btn-reveal-trigger position-static">
                                                <button
                                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                    @can('official_task_file-download')
                                                        <a class="dropdown-item"
                                                            href="{{ route('official-task-files.download', $officialTaskFile->id) }}">Download</a>
                                                    @endcan
                                                    @can('official_task_file-edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('official-task-files.edit', $officialTaskFile->id) }}">Edit</a>
                                                    @endcan
                                                    @can('official_task_file-delete')
                                                        <div class="dropdown-divider"></div>
                                                        <form method="POST"
                                                            action="{{ route('official-task-files.destroy', $officialTaskFile->id) }}"
                                                            style="display:inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger"
                                                                onclick="return confirm('Apakah anda yakin?')">Remove</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    @endcanany
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div
                    class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs-9 border-bottom border-translucent">
                    <div class="d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                        </p>
                        <a class="fw-semibold" href="#!" data-list-view="*">View all<span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                        <a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    </div>
                    <div class="d-flex">
                        <button class="page-link" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                        <ul class="mb-0 pagination"></ul>
                        <button class="page-link pe-0" data-list-pagination="next"><span
                                class="fas fa-chevron-right"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dash.layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const deleteButton = document.getElementById('delete-selected');
        const checkboxes = document.querySelectorAll('.select-item');
        let selectedItems = new Set();

        function updateCheckboxes() {
            checkboxes.forEach(checkbox => {
                if (selectedItems.has(checkbox.value)) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });
        }

        selectAllCheckbox.addEventListener('click', function(event) {
            const currentPageCheckboxes = document.querySelectorAll('.select-item');
            currentPageCheckboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
                if (event.target.checked) {
                    selectedItems.add(checkbox.value);
                } else {
                    selectedItems.delete(checkbox.value);
                }
            });
            toggleDeleteButton();
        });

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    selectedItems.add(checkbox.value);
                } else {
                    selectedItems.delete(checkbox.value);
                }
                toggleDeleteButton();
            });
        });

        function toggleDeleteButton() {
            deleteButton.disabled = selectedItems.size === 0;
        }

        // Initial check to set the button state on page load
        toggleDeleteButton();

        // Update the form submission to include all selected items
        document.getElementById('bulk-delete-form').addEventListener('submit', function(event) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'officialTaskFileIds';
            input.value = Array.from(selectedItems).join(',');
            this.appendChild(input);
        });

        // Update checkboxes when the page changes
        document.querySelectorAll('.page-link').forEach(function(pageLink) {
            pageLink.addEventListener('click', function() {
                setTimeout(updateCheckboxes, 100); // Adjust the timeout as needed
            });
        });
    });
</script>
