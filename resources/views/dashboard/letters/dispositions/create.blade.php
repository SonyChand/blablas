<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">Tambah surat masuk</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('incoming-letters.store') }}" onsubmit="showLoader(event)" enctype="multipart/form-data">
                @csrf
                <!-- New input fields for letters -->
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label>Sumber/Asal Surat</label>
                        <select class="form-select" id="source" data-choices="data-choices" multiple="multiple"
                            data-options='{"removeItemButton":true,"placeholder":true}' required name="source_letter[]">
                            <option hidden value="">Pilih Sumber/Asal Surat (Bisa lebih dari 1)</option>
                            <option value="provinsi" {{ in_array('provinsi', old('source', [])) ? 'selected' : '' }}>
                                Provinsi</option>
                            <option value="bupati" {{ in_array('bupati', old('source', [])) ? 'selected' : '' }}>Bupati
                            </option>
                            <option value="puskesmas" {{ in_array('puskesmas', old('source', [])) ? 'selected' : '' }}>
                                Puskesmas</option>
                            <option value="dinas_terkait"
                                {{ in_array('dinas_terkait', old('source', [])) ? 'selected' : '' }}>Dinas Terkait
                            </option>
                            <option value="lsm" {{ in_array('lsm', old('lsm', [])) ? 'selected' : '' }}>LSM
                            </option>
                            <option value="surat_kabar"
                                {{ in_array('surat_kabar', old('surat_kabar', [])) ? 'selected' : '' }}>Surat Kabar
                            </option>
                            <option value="lainnya" {{ in_array('lainnya', old('lainnya', [])) ? 'selected' : '' }}>
                                Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label>Ditujukan kepada</label>
                        <select class="form-select" id="addressed_to" data-choices="data-choices" multiple="multiple"
                            data-options='{"removeItemButton":true,"placeholder":true}' required name="addressed_to[]">
                            <option hidden value="">Pilih Ditujukan kepada (Bisa lebih dari 1)</option>
                            <option value="kepala_dinas"
                                {{ in_array('kepala_dinas', old('addressed_to', [])) ? 'selected' : '' }}>Kepala Dinas
                            </option>
                            <option value="kepala_bidang_p2p"
                                {{ in_array('kepala_bidang_p2p', old('addressed_to', [])) ? 'selected' : '' }}>Kepala
                                Bidang P2P</option>
                            <option value="kepala_bidan_yankes"
                                {{ in_array('kepala_bidan_yankes', old('addressed_to', [])) ? 'selected' : '' }}>Kepala
                                Bidan Yankes</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="number" type="text" name="letter_number"
                            placeholder="Nomor Surat" value="{{ old('letter_number') }}" required />
                        <label for="number">Nomor Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_date" type="date" name="letter_date"
                            value="{{ old('letter_date') }}" required />
                        <label for="letter_date">Tanggal Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="subject" type="text" name="subject" placeholder="Perihal"
                            value="{{ old('subject') }}" required />
                        <label for="subject">Perihal</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label for="attachment">Lampiran</label>
                        <select class="form-select" id="organizerSingle2" data-choices="data-choices" size="1"
                            name="attachment" data-options='{"removeItemButton":true,"placeholder":true}' required>
                            <option value="" hidden>Pilih Lampiran</option>
                            <option value="ada" {{ old('attachment') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak_ada" {{ old('attachment') == 'tidak_ada' ? 'selected' : '' }}>Tidak
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
                            <option value="kepala_dinas"
                                {{ in_array('kepala_dinas', old('forwarded_disposition', [])) ? 'selected' : '' }}>
                                Kepala Dinas</option>
                            <option value="kepala_bidang_p2p"
                                {{ in_array('kepala_bidang_p2p', old('forwarded_disposition', [])) ? 'selected' : '' }}>
                                Kepala Bidang P2P</option>
                            <option value="kepala_bidan_yankes"
                                {{ in_array('kepala_bidan_yankes', old('forwarded_disposition', [])) ? 'selected' : '' }}>
                                Kepala Bidan Yankes</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="operator_name" type="text" name="operator_name"
                            placeholder="Nama Operator/Admin" value="{{ old('operator_name') }}" required />
                        <label for="operator_name">Nama Operator/Admin</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <label for="file_path">Upload Lampiran</label>
                    <input class="form-control" id="file_path" type="file" name="file_path[]" accept=".pdf"
                        multiple />
                    <small class="text-muted">hanya format PDF. Bisa lebih dari 1.</small>
                </div>
                <!-- End of new input fields -->
                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Batal</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Tambah</button>
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
