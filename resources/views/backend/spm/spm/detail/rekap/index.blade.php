<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center d-print-none">
        <div class="col-auto">
            <h2 class="mb-0">{{ $title }}</h2>
        </div>
        <div class="col-auto">
            <form action="{{ route('spm.tahunspm') }}" method="POST" class="needs-validation" novalidate
                onsubmit="showLoader()">
                @csrf
                <div class="input-group mb-3">
                    <select name="tahun" class="form-select" id="tahun" required>
                        <option value="" hidden>Pilih Tahun</option>
                        @foreach ($tahuns as $tahunItem)
                            <option value="{{ $tahunItem->id }}"
                                {{ old('tahun', session('tahun_spm')) == $tahunItem->id ? 'selected' : '' }}>
                                {{ $tahunItem->tahun }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Pilih</button>
                </div>
            </form>
        </div>
    </div>



    <div class="card shadow-none border mb-4">
        <div class="card-header p-4 border-bottom bg-body d-print-none">
            <form action="{{ route('dashboard.chartSpmPuskesmas') }}" method="POST" class="needs-validation"
                novalidate>
                @csrf
                <div class="input-group">
                    <select name="posisi_chart_spm" class="form-select" id="posisi_chart_spm" required>
                        <option value="" hidden>Pilih Posisi Label</option>
                        <option value="1"
                            {{ old('posisi_chart_spm', session('posisi_chart_spm', 1)) == 1 ? 'selected' : '' }}>
                            Vertikal</option>
                        <option value="2"
                            {{ old('posisi_chart_spm', session('posisi_chart_spm', 1)) == 2 ? 'selected' : '' }}>
                            Horizontal</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Atur</button>
                </div>
            </form>
        </div>
        <div class="p-5 m-20 bg-inherit rounded shadow" id="chart-container">
            {!! $chart->container() !!}
        </div>

        @push('footer')
            <script src="{{ $chart->cdn() }}"></script>
            {{ $chart->script() }}
        @endpush
    </div>
</x-dash.layout>
