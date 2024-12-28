<x-dash.layout>
    @slot('title')
        Tambah SPM
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST" action="{{ route('spm.store') }}"
                onsubmit="showLoader(event)">
                @csrf

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <select class="form-select @error('puskesmas_id') is-invalid @enderror" id="puskesmas_id"
                            name="puskesmas_id" required>
                            <option value="" hidden>Pilih Puskesmas</option>
                            @foreach ($puskesmas as $puskesmasItem)
                                <option value="{{ $puskesmasItem->id }}"
                                    {{ old('puskesmas_id') == $puskesmasItem->id ? 'selected' : '' }}>
                                    {{ $puskesmasItem->nama }}
                                </option>
                            @endforeach
                        </select>
                        <label for="puskesmas_id">Pilih Puskesmas</label>
                        @error('puskesmas_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <select class="form-select @error('sub_layanan_id') is-invalid @enderror" id="sub_layanan_id"
                            name="sub_layanan_id" required>
                            <option value="" hidden>Pilih Sub Layanan</option>
                            @foreach ($subLayanans as $subLayananItem)
                                <option value="{{ $subLayananItem->id }}"
                                    {{ old('sub_layanan_id') == $subLayananItem->id ? 'selected' : '' }}>
                                    {{ $subLayananItem->uraian }}
                                </option>
                            @endforeach
                        </select>
                        <label for="sub_layanan_id">Pilih Sub Layanan</label>
                        @error('sub_layanan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <select class="form-select @error('tahun_id') is-invalid @enderror" id="tahun_id"
                            name="tahun_id" required>
                            <option value="" hidden>Pilih Tahun</option>
                            @foreach ($tahuns as $tahunItem)
                                <option value="{{ $tahunItem->id }}"
                                    {{ old('tahun_id') == $tahunItem->id ? 'selected' : '' }}>
                                    {{ $tahunItem->tahun }}
                                </option>
                            @endforeach
                        </select>
                        <label for="tahun_id">Pilih Tahun</label>
                        @error('tahun_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('dilayani') is-invalid @enderror" id="dilayani"
                            type="number" name="dilayani" placeholder="Dilayani" value="{{ old('dilayani') }}"
                            required />
                        <label for="dilayani">Dilayani</label>
                        @error('dilayani')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('terlayani') is-invalid @enderror" id="terlayani"
                            type="number" name="terlayani" placeholder="Terlayani" value="{{ old('terlayani') }}"
                            required />
                        <label for="terlayani">Terlayani</label>
                        @error('terlayani')
                            < div class="invalid-feedback">{{ $message }}
                        </div>
                    @enderror
                </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-floating">
                <input class="form-control @error('bulan') is-invalid @enderror" id="bulan" type="number"
                    name="bulan" placeholder="Bulan" value="{{ old('bulan') }}" required />
                <label for="bulan">Bulan</label>
                @error('bulan')
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
