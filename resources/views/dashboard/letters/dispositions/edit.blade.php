<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">Edit Disposisi</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('dispositions.update', $disposition->id) }}" onsubmit="showLoader(event)"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Updated input fields for dispositions -->
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_number" type="text" name="letter_number"
                            placeholder="Nomor Surat" value="{{ old('letter_number', $disposition->letter_number) }}"
                            required />
                        <label for="letter_number">Nomor Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="from" type="text" name="from" placeholder="Dari"
                            value="{{ old('from', $disposition->from) }}" required />
                        <label for="from">Dari</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label for="disposition_to">Ditujukan Kepada</label>
                        <select class="form-select" id="disposition_to" data-choices="data-choices" multiple="multiple"
                            data-options='{"removeItemButton":true,"placeholder":true}' required
                            name="disposition_to[]">
                            <option hidden value="">Pilih Ditujukan Kepada (Bisa lebih dari 1)</option>
                            @php
                                $dispositionToOptions = ['kepala_dinas', 'kepala_bidang_p2p', 'kepala_bidan_yankes'];
                                $dispositionTo = is_array(old('disposition_to', $disposition->disposition_to))
                                    ? old('disposition_to', $disposition->disposition_to)
                                    : [];
                            @endphp
                            @foreach ($dispositionToOptions as $option)
                                <option value="{{ $option }}"
                                    {{ in_array($option, $dispositionTo) ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $option)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="notes" name="notes" placeholder="Uraian Penugasan" required>{{ old('notes', $disposition->notes) }}</textarea>
                        <label for="notes">Uraian Penugasan</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="disposition_date" type="date" name="disposition_date"
                            value="{{ old('disposition_date', $disposition->disposition_date->format('Y-m-d')) }}"
                            placeholder="dd-mm-yyyy" required />
                        <label for="disposition_date">Tanggal Disposisi</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="signed_by" type="text" name="signed_by"
                            placeholder="Ditandatangani Oleh" value="{{ old('signed_by', $disposition->signed_by) }}"
                            required />
                        <label for="signed_by">Ditandatangani Oleh</label>
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
