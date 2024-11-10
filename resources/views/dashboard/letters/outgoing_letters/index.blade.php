<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="mb-9">
        <div id="projectSummary" data-list='{"valueNames":["id","email", "name", "whatsapp"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">Surat keluar<span class="fw-normal text-body-tertiary ms-3"></span></h2>
                </div>
            </div>
            <form method="POST" action="{{ route('outgoing-letters.bulkDestroy') }}" id="bulk-delete-form">
                @csrf
                @method('DELETE')
                <div class="row g-3 justify-content-between align-items-end mb-4">
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex align-items-center">
                            @can('outgoing_letter-create')
                                <div class="mt-3 mx-2">
                                    <a class="btn btn-primary btn-sm" href="{{ route('outgoing-letters.create') }}">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah
                                    </a>
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
                                <input class="form-control search-input search" type="search" placeholder="Cari surat"
                                    aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive scrollbar">
                    <table class="table fs-9 mb-0 border-top border-translucent">
                        <thead>
                            <tr>
                                <th class=" ps-3" style="width:2%;">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="sort  ps-3" scope="col" data-sort="id" style="width:6%;">No
                                </th>
                                <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="type">
                                    Jenis Surat</th>
                                <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="nomor">
                                    Nomor Surat</th>
                                <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="sifat">
                                    Sifat Surat</th>
                                <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="perihal">Perihal
                                </th>
                                <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="tanggal">Tanggal
                                    Surat</th>
                                <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="tujuan">Tujuan
                                    Surat</th>
                                </th>
                                <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="sifat">
                                    Sifat Surat
                                </th>
                                <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="lampiran">
                                    Lampiran
                                </th>
                                <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="operator">
                                    Nama
                                    Operator
                                </th>
                                @canany(['outgoing_letter-edit', 'outgoing_letter-delete', 'outgoing_letter-download'])
                                    <th class="sort text-end" scope="col"></th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="list" id="project-list-table-body">
                            @php $i = 0; @endphp
                            @foreach ($letters as $row)
                                <tr class="position-static">
                                    <td class=" text-center time white-space-nowrap ps-0 id py-4">
                                        <input type="checkbox" name="letterIds[]" value="{{ $row->id }}"
                                            class="select-item">
                                    </td>
                                    <td class=" text-center time white-space-nowrap ps-0 id py-4">
                                        {{ ++$i }}</td>
                                    <td class=" time white-space-nowrap ps-0 email py-4">
                                        {{ ucwords(str_replace('_', ' ', $row->letter_type)) }}
                                    </td>
                                    <td class=" time white-space-nowrap ps-0 nomor py-4">
                                        {{ $row->letter_number }}</td>
                                    <td class=" time white-space-nowrap ps-0 sifat py-4">
                                        {{ $row->letter_nature }}</td>
                                    <td class=" time white-space-nowrap ps-0 perihal py-4">
                                        {{ $row->letter_subject }}</td>
                                    <td class=" time white-space-nowrap ps-0 tanggal py-4">
                                        {{ $row->letter_date }}</td>
                                    <td class=" time white-space-nowrap ps-0 tujuan py-4">
                                        <ol>
                                            @foreach (json_decode($row->letter_destination) as $dest)
                                                <li>{{ ucwords(str_replace('_', ' ', $dest)) }}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td class=" time white-space-nowrap ps-0 sifat py-4">
                                        {{ $row->letter_nature }}</td>
                                    <td class=" time white-space-nowrap ps-0 lampiran py-4">
                                        {{ $row->attachment }}</td>
                                    <td class=" time white-space-nowrap ps-0 operator py-4">
                                        {{ $row->operator_name }}</td>
                                    @canany(['outgoing_letter-edit', 'outgoing_letter-delete',
                                        'outgoing_letter-download'])
                                        <td class=" text-end white-space-nowrap pe-0 action">
                                            <div class="btn-reveal-trigger position-static">
                                                <button
                                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                    @can('outgoing_letter-download')
                                                        <a class="dropdown-item"
                                                            href="{{ route('outgoing-letters.download', $row->id) }}">Download</a>
                                                    @endcan
                                                    @can('outgoing_letter-edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('outgoing-letters.edit', $row->id) }}">Edit</a>
                                                    @endcan
                                                    @can('outgoing_letter-delete')
                                                        <div class="dropdown-divider"></div>
                                                        <form method="POST"
                                                            action="{{ route('outgoing-letters.destroy', $row->id) }}"
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
            input.name = 'letterIds';
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
