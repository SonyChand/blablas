<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('master-letter-dispositions.update', $master->uuid) }}" onsubmit="showLoader(event)">
                @csrf
                @method('PUT')


                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <select class="form-select @error('employee_id') is-invalid @enderror" id="id"
                            name="employee_id" required>
                            <option value="" hidden>Pilih Pegawai dan Jabatan </option>
                            @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}"
                                    {{ $master->employee->id == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }} - {{ $emp->position }}</option>
                            @endforeach
                        </select>
                        <label for="employee_id">Pilih Pegawai dan Jabatan</label>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control @error('alias') is-invalid @enderror" id="alias" type="text"
                            name="alias" placeholder="Alias" value="{{ $master->alias }}" required />
                        <label for="alias">Alias</label>
                        @error('alias')
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
    @push('header')
        <link href="{{ asset('assets') }}/vendors/choices/choices.min.css" rel="stylesheet" />
    @endpush
    @push('footer')
        <script src="{{ asset('assets') }}/vendors/choices/choices.min.js"></script>
    @endpush
</x-dash.layout>
