<?php

namespace App\Models\Backend\SPM;

use App\Models\User;
use App\Models\Backend\SPM\Tahun;
use App\Models\Backend\SPM\SpmTotal;
use App\Models\Backend\SPM\Puskesmas;
use App\Models\Backend\SPM\SubLayanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spm extends Model
{
    use HasFactory;

    protected $table = 'spms';

    protected $fillable = [
        'puskesmas_id',
        'sub_layanan_id',
        'tahun_id',
        'dilayani',
        'terlayani',
        'belum_terlayani',
        'pencapaian',
        'bulan',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($spm) {
            $spm->calculateMetrics();
            $spm->updateSPMTotal();
            $spm->setUpdatedBy();
        });

        static::updating(function ($spm) {
            $spm->calculateMetrics();
            $spm->updateSPMTotal();
            $spm->setUpdatedBy();
        });
    }

    protected function calculateMetrics(): void
    {
        $this->belum_terlayani = ($this->dilayani - $this->terlayani) ?? 0;

        // Calculate pencapaian safely
        $this->pencapaian = $this->dilayani > 0
            ? ($this->terlayani / $this->dilayani) * 100
            : 0;
    }

    protected function updateSPMTotal(): void
    {
        $spmQuery = Spm::where([
            'puskesmas_id' => $this->puskesmas_id,
            'tahun_id' => $this->tahun_id,
            'sub_layanan_id' => $this->sub_layanan_id
        ]);

        $totalDilayani = $spmQuery->sum('dilayani');
        $totalTerlayani = $spmQuery->sum('terlayani');


        $spmTotal = SpmTotal::firstOrNew(['spm_id' => $this->id]);

        $spmTotal->spm_id = $this->id;
        $spmTotal->total_dilayani = $totalDilayani;
        $spmTotal->total_terlayani = $totalTerlayani;
        $spmTotal->total_belum_terlayani = $totalDilayani - $totalTerlayani;

        // Calculate total_pencapaian safely
        $spmTotal->total_pencapaian = $totalDilayani > 0
            ? ($totalTerlayani / $totalDilayani) * 100
            : 0;

        $spmTotal->save();
    }

    protected function setUpdatedBy(): void
    {
        if (auth()->check()) {
            $this->updated_by = auth()->id();
        }
    }

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id');
    }

    public function subLayanan()
    {
        return $this->belongsTo(SubLayanan::class, 'sub_layanan_id');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public static function filter($search)
    {
        return self::where(function ($query) use ($search) {
            $query->whereHas('puskesmas', function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            })
                ->orWhereHas('subLayanan', function ($q) use ($search) {
                    $q->where('kode', 'like', "%{$search}%")
                        ->orWhere('uraian', 'like', "%{$search}%")
                        ->orWhere('satuan', 'like', "%{$search}%");
                })
                ->orWhereHas('tahun', function ($q) use ($search) {
                    $q->where('tahun', 'like', "%{$search}%");
                })
                ->orWhere('dilayani', 'like', "%{$search}%")
                ->orWhere('terlayani', 'like', "%{$search}%")
                ->orWhere('belum_terlayani', 'like', "%{$search}%")
                ->orWhere('pencapaian', 'like', "%{$search}%")
                ->orWhere('bulan', 'like', "%{$search}%");
        });
    }
}
