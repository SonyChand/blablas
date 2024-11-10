<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">Edit surat keluar</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('outgoing-letters.update', $letter->id) }}" onsubmit="convertToJson()"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label for="letter_type">Tipe Surat</label>
                        <select class="form-select" id="letter_type" data-choices="data-choices" size="1"
                            name="letter_type" data-options='{"removeItemButton":true,"placeholder":true}' required>
                            <option value="" hidden>Pilih Tipe Surat</option>
                            <option value="surat_undangan"
                                {{ old('letter_type', $letter->letter_type) == 'surat_undangan' ? 'selected' : '' }}>
                                Surat Undangan
                            </option>
                            <option value="surat_dinas"
                                {{ old('letter_type', $letter->letter_type) == 'surat_dinas' ? 'selected' : '' }}>
                                Surat Dinas
                            </option>
                            <option value="surat_panggilan"
                                {{ old('letter_type', $letter->letter_type) == 'surat_panggilan' ? 'selected' : '' }}>
                                Surat Panggilan
                            </option>
                            <option value="surat_teguran"
                                {{ old('letter_type', $letter->letter_type) == 'surat_teguran' ? 'selected' : '' }}>
                                Surat Teguran
                            </option>
                            <option value="surat_pernyataan"
                                {{ old('letter_type', $letter->letter_type) == 'surat_pernyataan' ? 'selected' : '' }}>
                                Surat Pernyataan
                            </option>
                            <option value="surat_pernyataan_HUKDIS"
                                {{ old('letter_type', $letter->letter_type) == 'surat_pernyataan_HUKDIS' ? 'selected' : '' }}>
                                Surat
                                Pernyataan HUKDIS
                            </option>
                            <option value="surat_perjanjian_damai"
                                {{ old('letter_type', $letter->letter_type) == 'surat_perjanjian_damai' ? 'selected' : '' }}>
                                Surat Perjanjian Damai
                            </option>
                            <option value="surat_izin_magang"
                                {{ old('letter_type', $letter->letter_type) == 'surat_izin_magang' ? 'selected' : '' }}>
                                Surat Izin Magang
                            </option>
                            <option value="surat_SPMT"
                                {{ old('letter_type', $letter->letter_type) == 'surat_SPMT' ? 'selected' : '' }}>
                                Surat SPMT
                            </option>
                            <option value="lainnya"
                                {{ old('letter_type', $letter->letter_type) == 'lainnya' ? 'selected' : '' }}>
                                Lainnya
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="number" type="text" name="letter_number"
                            placeholder="Nomor Surat" value="{{ old('letter_number', $letter->letter_number) }}"
                            required />
                        <label for="number">Nomor Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating form-floating-advance-select">
                            <label for="letter_nature">Sifat Surat</label>
                            <select class="form-select" id="letter_nature" data-choices="data-choices" size="1"
                                name="letter_nature" data-options='{"removeItemButton":true,"placeholder":true}'
                                required>
                                <option value="" hidden>Pilih Sifat Surat</option>
                                <option value="penting"
                                    {{ old('letter_nature', $letter->letter_nature) == 'penting' ? 'selected' : '' }}>
                                    Penting
                                </option>
                                <option value="biasa"
                                    {{ old('letter_nature', $letter->letter_nature) == 'biasa' ? 'selected' : '' }}>
                                    Biasa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_subject" type="text" name="letter_subject"
                            placeholder="Perihal" value="{{ old('letter_subject', $letter->letter_subject) }}"
                            required />
                        <label for="letter_subject">Perihal</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_date" type="date" name="letter_date"
                            value="{{ old('letter_date', $letter->letter_date) }}" required />
                        <label for="letter_date">Tanggal Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="attachment" type="text" name="attachment"
                            placeholder="Lampiran" value="{{ old('attachment', $letter->attachment) }}" required />
                        <label for="attachment">Lampiran</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label>Tujuan Surat</label>
                        <select class="form-select" id="letter_destination" data-choices="data-choices"
                            multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'
                            name="letter_destination[]" required>
                            <option hidden value="">Pilih Tujuan Surat (Bisa lebih dari 1)</option>
                            @php
                                $forwarded = [
                                    'provinsi',
                                    'bupati',
                                    'puskesmas',
                                    'dinas_terkait',
                                    'PNS/P3K_dinkes',
                                    'PNS/P3K_puskesmas',
                                    'lainnya',
                                ];
                                $letterForward = is_array(
                                    old('letter_destination', json_decode($letter->letter_destination, true)),
                                )
                                    ? old('letter_destination', json_decode($letter->letter_destination, true))
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
                    <label>Ditandatangani oleh:</label>
                    <div class="form-floating my-2">
                        <input class="form-control" id="sign_name" type="text" name="sign_name" placeholder="Nama"
                            value="{{ old('sign_name', $letter->sign_name) }}" required />
                        <label for="sign_name">Nama</label>
                    </div>
                    <div class="form-floating my-2">
                        <input class="form-control" id="sign_nip" type="text" name="sign_nip" placeholder="NIP"
                            value="{{ old('sign_nip', $letter->sign_nip) }}" required />
                        <label for="sign_nip">NIP</label>
                    </div>
                    <div class="form-floating my-2">
                        <input class="form-control" id="sign_position" type="text" name="sign_position"
                            placeholder="Jabatan" value="{{ old('sign_position', $letter->sign_position) }}"
                            required />
                        <label for="sign_position">Jabatan</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="to" type="text" name="to" placeholder="Kepada Yth :" required
                            style="height: 100px">{{ old('to', $letter->to) }}</textarea>
                        <label for="to">Kepada Yth :</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="letter_body" type="text" name="letter_body" placeholder="Isi Surat :"
                            required style="height: 150px">{{ old('letter_body', $letter->letter_body) }}</textarea>
                        <label for="letter_body">Isi Surat :</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="letter_closing" type="text" name="letter_closing"
                            placeholder="Penutup Surat :" required style="height: 150px">{{ old('letter_closing', $letter->letter_closing) }}</textarea>
                        <label for="letter_closing">Penutup Surat :</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="operator_name" type="text" name="operator_name"
                            placeholder="Nama Operator/Admin"
                            value="{{ old('operator_name', $letter->operator_name) }}" required />
                        <label for="operator_name">Nama Operator/Admin</label>
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
                <input type="hidden" name="letter_destination_json" id="letter_destination_json">
            </form>
        </div>
    </div>
    <script>
        function convertToJson() {
            showLoader();
            const letterDestinationSelect = document.getElementById('letter_destination');
            document.getElementById('letter_destination_json').value = JSON.stringify(Array.from(letterDestinationSelect
                .selectedOptions).map(
                option => option.value));
        }
    </script>
</x-dash.layout>
