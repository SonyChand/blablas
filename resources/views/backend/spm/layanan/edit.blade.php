<x-dash.layout>
    @slot('title')
        Edit Layanan
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('master-spm-layanan.update', $layanan->id) }}" onsubmit="showLoader(event)">
                @csrf
                @method ('PUT')

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('kode') is-invalid @enderror" id="kode" type="text"
                            name="kode" placeholder="Kode" value="{{ old('kode', $layanan->kode) }}" required />
                        <label for="kode">Kode Layanan</label>
                        @error('kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('nama') is-invalid @enderror" id="nama" type="text"
                            name="nama" placeholder="Nama" value="{{ old('nama', $layanan->nama) }}" required />
                        <label for="nama">Nama Layanan</label>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('persentase') is-invalid @enderror" id="persentase"
                            type="number" name="persentase" placeholder="Persentase"
                            value="{{ old('persentase', $layanan->persentase) }}" required />
                        <label for="persentase">Persentase</label>
                        @error('persentase')
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
