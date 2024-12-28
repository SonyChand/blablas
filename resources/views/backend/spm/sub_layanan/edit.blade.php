<x-dash.layout>
    @slot('title')
        Edit Sub Layanan
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('master-spm-sub-layanan.update', $subLayanan->id) }}" onsubmit="showLoader(event)">
                @csrf
                @method('PUT')

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <select class="form-select @error('layanan_id') is-invalid @enderror" id="layanan_id"
                            name="layanan_id" required>
                            <option value="" hidden>Pilih Layanan</option>
                            @foreach ($layanans as $layananItem)
                                <option value="{{ $layananItem->id }}"
                                    {{ old('layanan_id', $subLayanan->layanan_id) == $layananItem->id ? 'selected' : '' }}>
                                    {{ $layananItem->nama }}
                                </option>
                            @endforeach
                        </select>
                        <label for="layanan_id">Pilih Layanan</label>
                        @error('layanan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('kode') is-invalid @enderror" id="kode" type="text"
                            name="kode" placeholder="Kode" value="{{ old('kode', $subLayanan->kode) }}" required />
                        <label for="kode">Kode Sub Layanan</label>
                        @error('kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('uraian') is-invalid @enderror" id="uraian" type="text"
                            name="uraian" placeholder="Uraian" value="{{ old('uraian', $subLayanan->uraian) }}"
                            required />
                        <label for="uraian">Uraian Sub Layanan</label>
                        @error('uraian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('satuan') is-invalid @enderror" id="satuan" type="text"
                            name="satuan" placeholder="Satuan" value="{{ old('satuan', $subLayanan->satuan) }}"
                            required />
                        <label for="satuan">Satuan</label>
                        @error('satuan')
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
