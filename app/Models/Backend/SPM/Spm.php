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
        'terlayani_januari',
        'terlayani_februari',
        'terlayani_maret',
        'terlayani_april',
        'terlayani_mei',
        'terlayani_juni',
        'terlayani_juli',
        'terlayani_agustus',
        'terlayani_september',
        'terlayani_oktober',
        'terlayani_november',
        'terlayani_desember',
        'total_dilayani',
        'updated_by',
    ];

    public static function totalTerlayani($subLayananId, $tahunId = null, $bulan = null)
    {
        $query = self::where('sub_layanan_id', $subLayananId);

        if ($tahunId) {
            $query->where('tahun_id', $tahunId);
        }

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        return $query->sum('terlayani_januari') +
            $query->sum('terlayani_februari') +
            $query->sum('terlayani_maret') +
            $query->sum('terlayani_april') +
            $query->sum('terlayani_mei') +
            $query->sum('terlayani_juni') +
            $query->sum('terlayani_juli') +
            $query->sum('terlayani_agustus') +
            $query->sum('terlayani_september') +
            $query->sum('terlayani_oktober') +
            $query->sum('terlayani_november') +
            $query->sum('terlayani_desember');
    }


    public static function totalPencapaian($subLayananId, $tahunId = null, $bulan = null)
    {
        $query = self::where('sub_layanan_id', $subLayananId);

        if ($tahunId) {
            $query->where('tahun_id', $tahunId);
        }

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        $totalTerlayani = self::totalTerlayani($subLayananId, $tahunId, $bulan);
        $totalDilayani = $query->sum('total_dilayani');

        // Validasi untuk menghindari division by zero
        if ($totalDilayani == 0) {
            return 0; // Atau bisa juga return null atau 'N/A' sesuai kebutuhan
        }

        return ($totalTerlayani / $totalDilayani) * 100;
    }

    public static function belumTerlayani($subLayananId, $tahunId = null, $bulan = null)
    {
        $query = self::where('sub_layanan_id', $subLayananId);

        if ($tahunId) {
            $query->where('tahun_id', $tahunId);
        }

        if ($bulan) {
            $query->where('bulan', $bulan);
        }
        $totalDilayani = $query->sum('total_dilayani');
        $totalTerlayani = self::totalTerlayani($subLayananId, $tahunId, $bulan);
        return $totalDilayani - $totalTerlayani;
    }

    public static function totalTerlayaniperBulan($subLayananId, $bulanId)
    {
        return self::where('sub_layanan_id', $subLayananId)
            ->sum('terlayani');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($spm) {
            $spm->setUpdatedBy();
        });

        static::updating(function ($spm) {
            $spm->setUpdatedBy();
        });
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
                ->orWhere('terlayani_januari', 'like', "%{$search}%")
                ->orWhere('terlayani_februari', 'like', "%{$search}%")
                ->orWhere('terlayani_maret', 'like', "%{$search}%")
                ->orWhere('terlayani_april', 'like', "%{$search}%")
                ->orWhere('terlayani_mei', 'like', "%{$search}%")
                ->orWhere('terlayani_juni', 'like', "%{$search}%")
                ->orWhere('terlayani_juli', 'like', "%{$search}%")
                ->orWhere('terlayani_agustus', 'like', "%{$search}%")
                ->orWhere('terlayani_september', 'like', "%{$search}%")
                ->orWhere('terlayani_oktober', 'like', "%{$search}%")
                ->orWhere('terlayani_november', 'like', "%{$search}%")
                ->orWhere('terlayani_desember', 'like', "%{$search}%")
                ->orWhere('total_dilayani', 'like', "%{$search}%");
        });
    }
}
