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
                    <div class="form-floating form-floating-advance-select">
                        <label for="letter_nature">Sifat Surat</label>
                        <select class="form-select" id="letter_nature" data-choices="data-choices"
                            data-options='{"removeItemButton":true,"placeholder":true}' required name="letter_nature">
                            <option hidden value="">Pilih Sifat Surat </option>
                            @php
                                $natureToOptions = ['sangat_segera', 'segera', 'rahasia'];
                                $natureTo = old('letter_nature', $disposition->letter_nature)
                                    ? old('letter_nature', $disposition->letter_nature)
                                    : '';
                            @endphp
                            @foreach ($natureToOptions as $option)
                                <option value="{{ $option }}"
                                    {{ $disposition->letter_nature == $option ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $option)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="agenda_number" type="text" name="agenda_number"
                            placeholder="Nomor Agenda" value="{{ old('agenda_number', $disposition->agenda_number) }}"
                            required />
                        <label for="agenda_number">Nomor Agenda</label>
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
                                $dispositionToOptions = ['kepala_dinas', 'kepala_bidang_p2p', 'kepala_bidang_yankes'];
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
                        <textarea class="form-control" id="notes" name="notes" placeholder="Catatan" required>{{ old('notes', $disposition->notes) }}</textarea>
                        <label for="notes">Catatan</label>
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
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating form-floating-advance-select">
                            <label for="signed_by">Ditandatangani oleh</label>
                            <select class="form-select" id="signed_by" data-choices="data-choices" size="1"
                                name="signed_by" data-options='{"removeItemButton":true,"placeholder":true}' required>
                                <option value="" hidden>Pilih Pegawai</option>
                                @foreach ($employees as $emp)
                                    <option value="{{ $emp->id }}"
                                        {{ $disposition->signed_by == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->name }} - {{ $emp->employee_identification_number }} -
                                        {{ $emp->rank }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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
