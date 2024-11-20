<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="mb-9">
        <div id="recommendationSummary"
            data-list='{"valueNames":["id","recommendation_type", "recommendation_number", "basis_of_recommendation", "recommendation_consideration", "recommended_data", "recommendation_purpose", "recommendation_closing", "recommendation_date", "signed_by", "operator_name"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">Daftar Rekomendasi<span class="fw-normal text-body-tertiary ms-3"></span></h2>
                </div>
            </div>
            <form method="POST" action="{{ route('recommendation-letters.bulkDestroy') }}" id="bulk-delete-form">
                @csrf
                @method('DELETE')
                <div class="row g-3 justify-content-between align-items-end mb-4">
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex align-items-center">
                            @can('recommendation-create')
                                <div class="mt-3 mx-2">
                                    <div class="btn-group">
                                        <a href="{{ route('recommendation-letters.create') }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-plus me-2"></i>Tambah Rekomendasi
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
                                    placeholder="Cari rekomendasi" aria-label="Search" />
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
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="recommendation_type">
                                    Jenis Rekomendasi</th>
                                <th class="sort white-space-nowrap ps-0" scope="col"
                                    data-sort="recommendation_number">Nomor Rekomendasi</th>
                                <th class="sort white-space-nowrap ps-0" scope="col"
                                    data-sort="basis_of_recommendation">Dasar Rekomendasi</th>
                                <th class="sort white-space-nowrap ps-0" scope="col"
                                    data-sort="recommendation_consideration">Pertimbangan Rekomendasi</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="recommended_data">
                                    Data yang Direkomendasikan</th>
                                <th class="sort white-space-nowrap ps-0" scope="col"
                                    data-sort="recommendation_purpose">Tujuan Rekomendasi</th>
                                <th class="sort white-space-nowrap ps-0" scope="col"
                                    data-sort="recommendation_closing">Penutup Rekomendasi</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="recommendation_date">
                                    Tanggal Rekomendasi</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="signed_by">
                                    Ditandatangani Oleh</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="operator_name">Nama
                                    Operator</th>
                                @canany(['recommendation-edit', 'recommendation-delete', 'recommendation-download'])
                                    <th class="sort text-end" scope="col"></th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="list" id="recommendation-list-table-body">
                            @php $i = 0; @endphp
                            @foreach ($recommendations as $recommendation)
                                <tr class="position-static">
                                    <td class="text-center time white-space-nowrap ps-0 id py-4">
                                        <input type="checkbox" name="recommendationIds[]"
                                            value="{{ $recommendation->id }}" class="select-item">
                                    </td>
                                    <td class="text-center time white-space-nowrap ps-0 id py-4">{{ ++$i }}
                                    </td>
                                    <td class="time white-space-nowrap ps-0 recommendation_type py-4">
                                        {{ $recommendation->recommendation_type }}</td>
                                    <td class="time white-space-nowrap ps-0 recommendation_number py-4">
                                        {{ $recommendation->recommendation_number }}</td>
                                    <td class="time white-space-nowrap ps-0 basis_of_recommendation py-4">
                                        {{ $recommendation->basis_of_recommendation }}</td>
                                    <td class="time white-space-nowrap ps-0 recommendation_consideration py-4">
                                        {{ $recommendation->recommendation_consideration }}</td>
                                    <td class="time white-space-nowrap ps-0 recommended_data py-4">
                                        {{ $recommendation->recommended_data }}</td>
                                    <td class="time white-space-nowrap ps-0 recommendation_purpose py-4">
                                        {{ $recommendation->recommendation_purpose }}</td>
                                    <td class="time white-space-nowrap ps-0 recommendation_closing py-4">
                                        {{ $recommendation->recommendation_closing }}</td>
                                    <td class="time white-space-nowrap ps-0 recommendation_date py-4">
                                        {{ $recommendation->recommendation_date->format('d-m-Y') }}</td>
                                    <td class="time white-space-nowrap ps-0 signed_by py-4">
                                        {{ $recommendation->signed_by }}</td>
                                    <td class="time white-space-nowrap ps-0 operator_name py-4">
                                        {{ $recommendation->operator_name }}</td>
                                    @canany(['recommendation-edit', 'recommendation-delete', 'recommendation-download'])
                                        <td class="text-end white-space-nowrap pe-0 action">
                                            <div class="btn-reveal-trigger position-static">
                                                <button
                                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                    @can('recommendation-download')
                                                        <a class="dropdown-item"
                                                            href="{{ route('recommendation-letters.download', $recommendation->id) }}">Download</a>
                                                    @endcan
                                                    @can('recommendation-edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('recommendation-letters.edit', $recommendation->id) }}">Edit</a>
                                                    @endcan
                                                    @can('recommendation-delete')
                                                        <div class="dropdown-divider"></div>
                                                        <form method="POST"
                                                            action="{{ route('recommendation-letters.destroy', $recommendation->id) }}"
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
            input.name = 'recommendationIds';
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
