<?php

namespace App\Http\Services\Backend\Spm;

use App\Models\Backend\SPM\Spm;
use Exception;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class SpmService
{
    protected $tableName = 'spms';
    public function dataTable($request)
    {
        if ($request->ajax()) {
            try {
                $totalData = Spm::where('tahun_id', session('tahun_spm') ?? 1)
                    ->where('puskesmas_id', Auth()->user()->puskesmas_id)
                    ->where('bulan', session('bulan_spm') ?? 1)->count();
                $totalFiltered = $totalData;

                $limit = $request->length;
                $start = $request->start;

                if (empty($request->search['value'])) {
                    $data = Spm::latest()
                        ->where('tahun_id', session('tahun_spm', 1))
                        ->where('bulan', session('bulan_spm', 1))
                        ->where('puskesmas_id', Auth()->user()->puskesmas_id)
                        ->with('subLayanan:id,kode,uraian,satuan')
                        ->skip($start)
                        ->take($limit)
                        ->orderBy('id', 'ASC')
                        ->get(array_merge(['id'], $this->columns()));
                } else {
                    $data = Spm::filter($request->search['value'])
                        ->latest()
                        ->where('tahun_id', session('tahun_spm', 1))
                        ->where('bulan', session('bulan_spm', 1))
                        ->where('puskesmas_id', Auth()->user()->puskesmas_id)
                        ->with('subLayanan:id,kode,uraian,satuan')
                        ->skip($start)
                        ->take($limit)
                        ->orderBy('id', 'ASC')
                        ->get(array_merge(['id'], $this->columns()));

                    $totalFiltered = $data->count();
                }

                return DataTables::of($data)
                    ->setOffset($start)
                    ->editColumn('sub_layanan_id', function ($data) {
                        return $data->subLayanan->uraian;
                    })
                    ->editColumn('tahun_id', function ($data) {
                        return $data->tahun->tahun;
                    })
                    ->editColumn('bulan', function ($data) {
                        return date('M', mktime(0, 0, 0, $data->bulan, 1, 2000));
                    })
                    ->editColumn('updated_by', function ($data) {
                        return $data->user->name ?? 0;
                    })
                    ->addColumn('kode', function ($data) {
                        $kode = '
                        <div class="text-center">' . $data->subLayanan->kode . '</div>';
                        return $kode;
                    })
                    ->addColumn('action', function ($data) {
                        $actionBtn = '
                    <div class="text-center" width="10%">
                        <div class="btn-group mx-1">

                        <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="' . $data->id . '">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(this)" data-id="' . $data->id . '">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                ';

                        return $actionBtn;
                    })
                    ->rawColumns(array_merge($this->columns(), ['action', 'kode']))
                    ->with([
                        'recordsTotal' => $totalData,
                        'recordsFiltered' => $totalFiltered,
                        'start' => $start
                    ])
                    ->make();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }


    public function getFirstBy(string $column, string $value, bool $relation = false)
    {
        return Spm::where($column, $value)->firstOrFail();
    }

    public function create(array $data)
    {
        $spm = Spm::create($data);

        return $spm;
    }

    public function update(array $data, string $id)
    {
        $spm = Spm::where('id', $id)->firstOrFail();
        $spm->update($data);

        return $spm;
    }

    public function forceDelete(string $id)
    {
        $getSPM = $this->getFirstBy('id', $id);
        // Storage::disk('public')->delete('images/' . $getSPM->image);
        $getSPM->forceDelete();

        return $getSPM;
    }

    public function columnLabels()
    {
        return [
            'sub_layanan_id' => 'Uraian',
            'tahun_id' => 'Tahun',
            'dilayani' => 'Dilayani',
            'terlayani' => 'Terlayani',
            'belum_terlayani' => 'Belum Terlayani',
            'pencapaian' => 'Pencapaian',
            'updated_by' => 'Diubah Oleh',
        ];
    }

    public function columnExclude()
    {
        return ['id', 'bulan', 'updated_by', 'created_at', 'updated_at'];
    }

    public function columnTypes()
    {
        return [

            'sub_layanan_id' => 'sub_layanans',
            'tahun_id' => 'tahuns',
            'dilayani' => 'integer',
            'terlayani' => 'integer',
            'belum_terlayani' => 'integer',
            'pencapaian' => 'decimal',
        ];
    }

    public function columns()
    {
        return array_diff(Schema::getColumnListing((new Spm())->getTable()), $this->columnExclude());
    }


    public function getAttributesWithDetails()
    {
        // Get the columns from the table, excluding specific columns
        $columns = Schema::getColumnListing($this->tableName);
        $excludedColumns = $this->columnExclude();
        $filteredColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        // Define your labels and data types
        $labels = $this->columnLabels();

        $dataTypes = $this->columnTypes();

        // Create an array with keys, their corresponding labels, data types, and required status
        $attributesWithDetails = [];
        foreach ($filteredColumns as $column) {
            if (array_key_exists($column, $labels) && array_key_exists($column, $dataTypes)) {
                // Check if the column is nullable
                if (app()->make('db')->connection()->getDriverName() === 'sqlite') {
                    // Get column info for SQLite
                    $columnsInfo = app()->make('db')->select("PRAGMA table_info($this->tableName)");
                    $columnInfo = collect($columnsInfo)->firstWhere('name', $column);
                    $isNullable = $columnInfo->notnull == 0; // notnull is 0 if the column is nullable
                } else {
                    // Use information_schema for other databases
                    $result = app()->make('db')->select("SELECT is_nullable FROM information_schema.columns WHERE table_name = ? AND column_name = ?", [$this->tableName, $column]);

                    if (empty($result)) {
                        throw new Exception("No results found for the specified table and column.");
                    }

                    $isNullable = $result[0]->IS_NULLABLE === 'YES';
                }

                $attributesWithDetails[$column] = [
                    'label' => $labels[$column],
                    'type' => $dataTypes[$column],
                    'required' => !$isNullable, // Required if not nullable
                ];
            }
        }

        return $attributesWithDetails;
    }
}
