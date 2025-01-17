<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        * {
            font-size: 8pt !important;
        }
    </style>
</head>

<body>
    @php
        $i = 1;
    @endphp

    <form action="{{ route('spm.fullStore') }}" method="POST">
        @csrf
        <div class="fixed-bottom text-end my-2 mx-2 d-print-none">
            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>
        </div>
        <div class="fixed-top text-end my-2 mx-2">
            <span class="badge bg-warning">Versi 2</span>
            <span class="badge bg-primary">{{ Auth::user()->puskesmas->nama ?? 'Dinas Kesehatan' }}</span>
            <span class="badge bg-secondary">Tahun : {{ $tahun->tahun }}</span>
        </div>
        <table class="table table-bordered" style="margin-bottom: 100pt">
            <thead class="text-center align-middle">
                <tr>
                    <th colspan="19" class="text-start">A. PERSENTASE PENCAPAIAN PENERIMA LAYANAN DASAR (80%)</th>
                </tr>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Uraian SPM</th>
                    <th rowspan="2">Satuan</th>
                    <th rowspan="2">Jumlah Total Yang Harus Dilayani </th>
                    <th colspan="13">Jumlah Yang Terlayani</th>
                    <th rowspan="2">Yang Belum Terlayani</th>
                    <th rowspan="2">%</th>
                </tr>
                <tr>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>Mei</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Agu</th>
                    <th>Sep</th>
                    <th>Okt</th>
                    <th>Nov</th>
                    <th>Des</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanan1 as $layanan1)
                    @php
                        $data = \App\Models\Backend\SPM\Spm::where('tahun_id', $tahun->id)
                            ->where('sub_layanan_id', $layanan1->id)
                            ->where('puskesmas_id', Auth::user()->puskesmas_id ?? 1)
                            ->first();
                    @endphp
                    <tr>
                        <td style="width: 1%">{{ $layanan1->kode }}</td>
                        <td style="width: 8%">
                            <textarea class="form-control" name="uraian[{{ $layanan1->id }}]" rows="5">{{ $layanan1->uraian }}</textarea>
                        </td>
                        <td style="width: 1%">{{ $layanan1->satuan }}</td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->total_dilayani, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_januari, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_februari, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->terlayani_maret, 0, ',', '.') }}
                            </ td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->terlayani_april, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->terlayani_mei, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->terlayani_juni, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->terlayani_juli, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_agustus, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_september, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_oktober, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_november, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_desember, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->total_terlayani, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->belum_terlayani, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">{{ round($data->pencapaian, 2) }}%</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <table class="table table-bordered" style="margin-bottom: 100pt">
            <thead class="text-center align-middle">
                <tr>
                    <th colspan="19" class="text-start">B. PERSENTASE PENCAPAIAN MUTU MINIMAL LAYANAN DASAR (20%)</th>
                </tr>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Uraian SPM</th>
                    <th rowspan="2">Satuan</th>
                    <th rowspan="2">
                        Jumlah Mutu
                        Yang Harus
                        Dilayani / Dipenuhi
                    </th>
                    <th colspan="13">Jumlah Mutu Yang Terlayani / Terpenuhi </th>
                    <th rowspan="2">
                        Mutu Yang Belum
                        Terlayani / Terpenuhi
                    </th>
                    <th rowspan="2">%</th>
                </tr>
                <tr>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>Mei</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Agu</th>
                    <th>Sep</th>
                    <th>Okt</th>
                    <th>Nov</th>
                    <th>Des</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanan2 as $layanan2)
                    @php
                        $data = \App\Models\Backend\SPM\Spm::where('tahun_id', $tahun->id)
                            ->where('sub_layanan_id', $layanan2->id)
                            ->where('puskesmas_id', Auth::user()->puskesmas_id ?? 1)
                            ->first();
                        $keyCode = preg_replace('/B/', 'A', $layanan2->kode);
                        $header = \App\Models\Backend\SPM\SubLayanan::where('kode', $keyCode)->first();
                    @endphp
                    @if ($header != null)
                        @php
                            $nilaiHeader = \App\Models\Backend\SPM\Spm::where('sub_layanan_id', $header->id)
                                ->where('tahun_id', $tahun->id)
                                ->where('puskesmas_id', Auth::user()->puskesmas_id ?? 1)
                                ->first();
                        @endphp
                        <tr style="background: yellow" class="fw-bold">
                            <td style="width: 1%" class="text-end">{{ $i++ }}</td>
                            <td colspan="2" class="text-start">{{ $header->uraian }}</td>
                            <td class="text-end">{{ $nilaiHeader->total_dilayani }}</td>
                            <td colspan="12"></td>
                            <td class="text-end">{{ $nilaiHeader->total_terlayani }}</td>
                            <td class="text-end">{{ $nilaiHeader->belum_terlayani }}</td>
                            <td class="text-center">{{ round($nilaiHeader->pencapaian, 2) }}%</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="width: 1%">{{ $layanan2->kode }}</td>
                        <td style="width: 8%">
                            <textarea class="form-control" name="uraian[{{ $layanan2->id }}]" rows="5">{{ $layanan2->uraian }}</textarea>
                        </td>
                        <td style="width: 1%">{{ $layanan2->satuan }}</td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->total_dilayani, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_januari, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_februari, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_maret, 0, ',', '.') }}
                            </ td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_april, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->terlayani_mei, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_juni, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_juli, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_agustus, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_september, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_oktober, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_november, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_desember, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->total_terlayani, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->belum_terlayani, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">{{ round($data->pencapaian, 2) }}%</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <table class="table table-bordered" style="margin-bottom: 50pt">
            <thead class="text-center align-middle">
                <tr>
                    <th colspan="19" class="text-start">C. ALOKASI ANGGARAN DAN REALISASI
                    </th>
                </tr>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Uraian SPM</th>
                    <th rowspan="2">Satuan</th>
                    <th rowspan="2">
                        Alokasi Anggaran (Rp.)
                    </th>
                    <th colspan="13">Realisasi (Rp.) </th>
                    <th rowspan="2">
                        Selisih
                    </th>
                    <th rowspan="2">%</th>
                </tr>
                <tr>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>Mei</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Agu</th>
                    <th>Sep</th>
                    <th>Okt</th>
                    <th>Nov</th>
                    <th>Des</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanan3 as $layanan3)
                    @php
                        $data = \App\Models\Backend\SPM\Spm::where('tahun_id', $tahun->id)
                            ->where('sub_layanan_id', $layanan3->id)
                            ->where('puskesmas_id', Auth::user()->puskesmas_id ?? 1)
                            ->first();
                    @endphp
                    <tr>
                        <td style="width: 1%">{{ $layanan3->kode }}</td>
                        <td style="width: 8%">
                            <textarea class="form-control" name="uraian[{{ $layanan3->id }}]" rows="5">{{ $layanan3->uraian }}</textarea>
                        </td>
                        <td style="width: 1%">{{ $layanan3->satuan }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->total_dilayani, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_januari, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_februari, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_maret, 0, ',', '.') }}
                            </ td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_april, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">{{ number_format($data->terlayani_mei, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_juni, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_juli, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_agustus, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_september, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_oktober, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_november, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->terlayani_desember, 0, ',', '.') }}</td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->total_terlayani, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">
                            {{ number_format($data->belum_terlayani, 0, ',', '.') }}
                        </td>
                        <td style="width: 2%" class="text-end">{{ round($data->pencapaian, 2) }}%</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </form>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
