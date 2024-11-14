<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">Tambah Data Pegawai</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('employees.store') }}" onsubmit="showLoader(event)">
                @csrf
                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text"
                            name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required />
                        <label for="name">Nama Lengkap</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('employee_type') is-invalid @enderror" id="employee_type"
                            name="employee_type" required>
                            <option value="" hidden>Pilih Jenis Pegawai</option>
                            <option value="PNS" {{ old('employee_type') == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="PPPK" {{ old('employee_type') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        </select>
                        <label for="employee_type">Jenis Pegawai</label>
                        @error('employee_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('employee_identification_number') is-invalid @enderror"
                            id="employee_identification_number" type="text" name="employee_identification_number"
                            placeholder="NIP" value="{{ old('employee_identification_number') }}" required />
                        <label for="employee_identification_number">NIP</label>
                        @error('employee_identification_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('birth_place') is-invalid @enderror" id="birth_place"
                            type="text" name="birth_place" placeholder="Tempat Lahir"
                            value="{{ old('birth_place') }}" required />
                        <label for="birth_place">Tempat Lahir</label>
                        @error('birth_place')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                            type="date" name="birth_date" placeholder="Tanggal Lahir"
                            value="{{ old('birth_date') }}" required />
                        <label for="birth_date">Tanggal Lahir</label>
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('rank_start_date') is-invalid @enderror" id="rank_start_date"
                            type="date" name="rank_start_date" placeholder="TMT Pangkat"
                            value="{{ old('rank_start_date') }}" required />
                        <label for="rank_start_date">TMT Pangkat</label>
                        @error('rank_start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating form-floating-advance-select"><label for="floaTingLabelSingleSelect">Pilih
                            Pangkat/Golongan</label><select class="form-select" id="floaTingLabelSingleSelect"
                            data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'
                            name="rank" id="rank" required>
                            <option value="" hidden>Pilih Pangkat/Golongan</option>
                            @foreach (['Pembina Utama - IV/e', 'Pembina Utama Madya - IV/d', 'Pembina Utama Muda - IV/c', 'Pembina Tk. I - IV/b', 'Pembina - IV/a', 'Penata Tk. I - III/d', 'Penata - III/c', 'Penata Muda Tk. I - III/b', 'Penata Muda - III/a', 'Pengatur Tk. I - II/d', 'Pengatur - II/c', 'Pengatur Muda Tk. I - II/b', 'Pengatur Muda - II/a', 'Juru Tk. I - I/d', 'Juru - I/c', 'Juru Muda Tk. I - I/b', 'Juru Muda - I/a'] as $rank)
                                <option value="{{ $rank }}" {{ old('rank') == $rank ? 'selected' : '' }}>
                                    {{ $rank }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('position_start_date') is-invalid @enderror"
                            id="position_start_date" type="date" name="position_start_date" placeholder="TMT Jabatan"
                            value="{{ old('position_start_date') }}" required />
                        <label for="position_start_date">TMT Jabatan</label>
                        @error('position_start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('position') is-invalid @enderror" id="position"
                            type="text" name="position" placeholder="Jabatan" value="{{ old('position') }}" />
                        <label for="position">Jabatan</label>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('education_level') is-invalid @enderror"
                            id="education_level" name="education_level">
                            <option value="" hidden>Pilih Pendidikan Terakhir</option>
                            @foreach (['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'Diploma 3', 'Diploma 4 / Sarjana', 'Magister', 'Doktor', 'Profesional'] as $level)
                                <option value="{{ $level }}"
                                    {{ old('education_level') == $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                        <label for="education_level">Pendidikan Terakhir</label>
                        @error('education_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('education_institution') is-invalid @enderror"
                            id="education_institution" type="text" name="education_institution"
                            placeholder="Nama Perguruan Tinggi" value="{{ old('education_institution') }}" />
                        <label for="education_institution">Nama Perguruan Tinggi</label>
                        @error('education_institution')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('major') is-invalid @enderror" id="major"
                            type="text" name="major" placeholder="Jurusan" value="{{ old('major') }}" />
                        <label for="major">Jurusan</label>
                        @error('major')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('graduation_date') is-invalid @enderror"
                            id="graduation_date" type="date" name="graduation_date" placeholder="Tanggal Lulus"
                            value="{{ old('graduation_date') }}" />
                        <label for="graduation_date">Tanggal Lulus</label>
                        @error('graduation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                            name="user_id">
                            <option value="" hidden>Hubungkan dengan akun {{ config('app.name', 'sistem') }}
                            </option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                            <option value="">Nanti saja</option>
                        </select>
                        <label for="user_id">Hubungkan dengan akun {{ config('app.name', 'sistem') }}</label>
                    </div>
                </div>



                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('email') is-invalid @enderror" id="email"
                            type="email" name="email" placeholder="Alamat Email (Wajib aktif)"
                            value="{{ old('email') }}" required />
                        <label for="email">Alamat Email (Wajib aktif)</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating form-floating-advance-select mb-3"><label
                            for="floaTingLabelSingleSelect">Pilih Unit Kerja</label><select class="form-select"
                            id="floaTingLabelSingleSelect" data-choices="data-choices"
                            data-options='{"removeItemButton":true,"placeholder":true}' name="work_unit"
                            id="work_unit" required>
                            <option value="" hidden>Pilih Unit Kerja</option>
                            @foreach ([
        'DINKES KAB. CIAMIS (SEKRETARIAT)',
        'DINKES KAB. CIAMIS (P2P)',
        'DINKES KAB. CIAMIS (KESMAS)',
        'DINKES KAB. CIAMIS (SDK)',
        'DINKES KAB. CIAMIS (YANKES)',
        'UPTD FARMASI KAB. CIAMIS',
        'UPTD LABKESDA KAB. CIAMIS',
        'UPTD PUSKESMAS BANJARSARI',
        'UPTD PUSKESMAS BAREGBEG',
        'UPTD PUSKESMAS CIAMIS',
        'UPTD PUSKESMAS CIDOLOG',
        'UPTD PUSKESMAS CIEURIH',
        'UPTD PUSKESMAS CIGAYAM',
        'UPTD PUSKESMAS CIHAURBEUTI',
        'UPTD PUSKESMAS CIJEUNGJING',
        'UPTD PUSKESMAS CIKONENG',
        'UPTD PUSKESMAS CIMARAGAS',
        'UPTD PUSKESMAS CIPAKU',
        'UPTD PUSKESMAS CISAGA',
        'UPTD PUSKESMAS CIULU',
        'UPTD PUSKESMAS GARDUJAYA',
        'UPTD PUSKESMAS HANDAPHERANG',
        'UPTD PUSKESMAS IMBANAGARA',
        'UPTD PUSKESMAS JATINAGARA',
        'UPTD PUSKESMAS KAWALI',
        'UPTD PUSKESMAS KAWALIMUKTI',
        'UPTD PUSKESMAS KERTAHAYU',
        'UPTD PUSKESMAS LAKBOK',
        'UPTD PUSKESMAS LUMBUNG',
        'UPTD PUSKESMAS PAMARICAN',
        'UPTD PUSKESMAS PANAWANGAN',
        'UPTD PUSKESMAS PANJALU',
        'UPTD PUSKESMAS PANUMBANGAN',
        'UPTD PUSKESMAS PAYUNGSARI',
        'UPTD PUSKESMAS PURWADADI',
        'UPTD PUSKESMAS RAJADESA',
        'UPTD PUSKESMAS RANCAH',
        'UPTD PUSKESMAS SADANANYA',
        'UPTD PUSKESMAS SIDAHARJA',
        'UPTD PUSKESMAS SINDANGKASIH',
        'UPTD PUSKESMAS SUKADANA',
        'UPTD PUSKESMAS SUKAMANTRI',
        'UPTD PUSKESMAS SUKAMULYA',
        'UPTD PUSKESMAS TAMBAKSARI',
    ] as $rank)
                                <option value="{{ $rank }}" {{ old('rank') == $rank ? 'selected' : '' }}>
                                    {{ $rank }}</option>
                            @endforeach
                        </select>
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
    @push('header')
        <link href="{{ asset('assets') }}/vendors/choices/choices.min.css" rel="stylesheet" />
    @endpush
    @push('footer')
        <script src="{{ asset('assets') }}/vendors/choices/choices.min.js"></script>
    @endpush
</x-dash.layout>
