<x-dash.layout>
    @slot('title')
        Tambah Tahun
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('master-spm-tahun.store') }}" onsubmit="showLoader(event)">
                @csrf

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('tahun') is-invalid @enderror" id="tahun" type="number"
                            name="tahun" placeholder="Tahun" value="{{ old('tahun') }}" required />
                        <label for="tahun">Tahun</label>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Batal</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dash.layout>
