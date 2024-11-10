<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">Edit surat masuk</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('incoming-letters.update', $incoming_letter->id) }}" onsubmit="showLoader(event)"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Updated input fields for letters -->
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label>Sumber/Asal Surat</label>
                        <select class="form-select" id="source_letter" data-choices="data-choices" multiple="multiple"
                            data-options='{"removeItemButton":true,"placeholder":true}' required name="source_letter[]">
                            <option hidden value="">Pilih Sumber/Asal Surat (Bisa lebih dari 1)</option>
                            @php
                                $source = [
                                    'provinsi',
                                    'bupati',
                                    'puskesmas',
                                    'dinas_terkait',
                                    'lsm',
                                    'lainnya',
                                    'surat_kabar',
                                ];
                                $letterSource = is_array(old('source_letter', $incoming_letter->source_letter))
                                    ? old('source_letter', $incoming_letter->source_letter)
                                    : [];
                            @endphp
                            @foreach ($source as $row)
                                <option value="{{ $row }}"
                                    {{ in_array($row, $letterSource) ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $row)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label>Ditujukan kepada</label>
                        <select class="form-select" id="addressed_to" data-choices="data-choices" multiple="multiple"
                            data-options='{"removeItemButton":true,"placeholder":true}' required name="addressed_to[]">
                            <option hidden value="">Pilih Ditujukan kepada (Bisa lebih dari 1)</option>
                            @php
                                $addressed_to = ['kepala_dinas', 'kepala_bidang_p2p', 'kepala_bidan_yankes'];
                                $letterAddress = is_array(old('addressed_to', $incoming_letter->addressed_to))
                                    ? old('addressed_to', $incoming_letter->addressed_to)
                                    : [];
                            @endphp
                            @foreach ($addressed_to as $row)
                                <option value="{{ $row }}"
                                    {{ in_array($row, $letterAddress) ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $row)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="number" type="text" name="letter_number"
                            placeholder="Nomor Surat"
                            value="{{ old('letter_number', $incoming_letter->letter_number) }}" required />
                        <label for="number">Nomor Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_date" type="date" name="letter_date"
                            value="{{ old('letter_date', $incoming_letter->letter_date->format('Y-m-d')) }}"
                            placeholder="dd-mm-yyyy" required />
                        <label for="letter_date">Tanggal Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="subject" type="text" name="subject" placeholder="Perihal"
                            value="{{ old('subject', $incoming_letter->subject) }}" required />
                        <label for="subject">Perihal</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label for="attachment">Lampiran</label>
                        <select class="form-select" id="organizerSingle2" data-choices="data-choices" size="1"
                            name="attachment" data-options='{"removeItemButton":true,"placeholder":true}' required>
                            <option value="" hidden>Pilih Lampiran</option>
                            <option value="ada"
                                {{ old('attachment', $incoming_letter->attachment) == 'ada' ? 'selected' : '' }}>Ada
                            </option>
                            <option value="tidak_ada"
                                {{ old('attachment', $incoming_letter->attachment) == 'tidak_ada' ? 'selected' : '' }}>
                                Tidak
                                Ada</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label>Diteruskan/Disposisi</label>
                        <select class="form-select" id="forwarded_disposition" data-choices="data-choices"
                            multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'
                            name="forwarded_disposition[]" required>
                            <option hidden value="">Pilih Diteruskan/Disposisi (Bisa lebih dari 1)</option>

                            @php
                                $forwarded = ['kepala_dinas', 'kepala_bidang_p2p', 'kepala_bidan_yankes'];
                                $letterForward = is_array(
                                    old('forwarded_disposition', $incoming_letter->forwarded_disposition),
                                )
                                    ? old('forwarded_disposition', $incoming_letter->forwarded_disposition)
                                    : [];
                            @endphp
                            @foreach ($forwarded as $row)
                                <option value="{{ $row }}"
                                    {{ in_array($row, $letterForward) ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $row)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="operator_name" type="text" name="operator_name"
                            placeholder="Nama Operator/Admin"
                            value="{{ old('operator_name', $incoming_letter->operator_name) }}" required />
                        <label for="operator_name">Nama Operator/Admin</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <label for="file_path">Upload Surat Masuk</label>
                    <input class="form-control" id="file_path" type="file" name="file_path[]" accept=".pdf"
                        multiple />
                    <small class="text-muted">hanya format PDF dan gambar. bisa lebih dari 1.</small>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="delete_previous_files"
                            name="delete_previous_files" value="1">
                        <label class="form-check-label" for="delete_previous_files">
                            Hapus seluruh file sebelumnya
                        </label>
                    </div>
                </div>
                <!-- End of updated input fields -->
                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Batal</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Edit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('header')
        <link rel="stylesheet" href="{{ asset('assets/vendors/choices/choices.min.css') }}">
    @endpush
    @push('footer')
        <script src="{{ asset('assets/vendors/choices/choices.min.js') }}"></script>
    @endpush
</x-dash.layout>
