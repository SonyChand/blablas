<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">Tambah Rekomendasi</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('recommendation-letters.store') }}" onsubmit="showLoader(event)">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="recommendation_type" type="text" name="recommendation_type"
                            placeholder="Jenis Rekomendasi" value="{{ old('recommendation_type') }}" required />
                        <label for="recommendation_type">Jenis Rekomendasi</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="recommendation_number" type="text"
                            name="recommendation_number" placeholder="Nomor Rekomendasi"
                            value="{{ old('recommendation_number') }}" required />
                        <label for="recommendation_number">Nomor Rekomendasi</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="basis_of_recommendation" type="text"
                            name="basis_of_recommendation" placeholder="Dasar Rekomendasi"
                            value="{{ old('basis_of_recommendation') }}" required />
                        <label for="basis_of_recommendation">Dasar Rekomendasi</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="recommendation_consideration" type="text"
                            name="recommendation_consideration" placeholder="Pertimbangan Rekomendasi"
                            value="{{ old('recommendation_consideration') }}" required />
                        <label for="recommendation_consideration">Pertimbangan Rekomendasi</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="recommended_data" name="recommended_data" placeholder="Data yang Direkomendasikan"
                            required>{{ old('recommended_data') }}</textarea>
                        <label for="recommended_data">Data yang Direkomendasikan</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="recommendation_purpose" type="text"
                            name="recommendation_purpose" placeholder="Tujuan Rekomendasi"
                            value="{{ old('recommendation_purpose') }}" required />
                        <label for="recommendation_purpose">Tujuan Rekomendasi</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="recommendation_closing" name="recommendation_closing"
                            placeholder="Penutup Rekomendasi" required>{{ old('recommendation_closing') }}</textarea>
                        <label for="recommendation_closing">Penutup Rekomendasi</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="recommendation_date" type="date" name="recommendation_date"
                            value="{{ old('recommendation_date') }}" required />
                        <label for="recommendation_date">Tanggal Rekomendasi</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="signed_by" type="text" name="signed_by"
                            placeholder="Ditandatangani Oleh" value="{{ old('signed_by') }}" required />
                        <label for="signed_by">Ditandatangani Oleh</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="operator_name" type="text" name="operator_name"
                            placeholder="Nama Operator" value="{{ old('operator_name') }}" required />
                        <label for="operator_name">Nama Operator</label>
                    </div>
                </div>
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
