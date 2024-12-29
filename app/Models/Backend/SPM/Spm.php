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

    public function getTotalTerlayaniJanuariAttribute()
    {
        return self::where('sub_layanan_id', $this->sub_layanan_id)
            ->where('tahun_id', session('tahun_spm', 1))
            ->sum('terlayani_januari');
    }



    public function getTotalTerlayaniAttribute()
    {
        return $this->terlayani_januari +
            $this->terlayani_februari +
            $this->terlayani_maret +
            $this->terlayani_april +
            $this->terlayani_mei +
            $this->terlayani_juni +
            $this->terlayani_juli +
            $this->terlayani_agustus +
            $this->terlayani_september +
            $this->terlayani_oktober +
            $this->terlayani_november +
            $this->terlayani_desember;
    }


    public function getPencapaianAttribute()
    {
        $totalDilayani = $this->total_dilayani ?? 0; // Ensure it's not null
        $totalTerlayani = $this->total_terlayani; // Use the existing accessor

        // Validasi untuk menghindari division by zero
        if ($totalDilayani == 0) {
            return 0; // Or return null or 'N/A' as per your requirement
        }

        return ($totalTerlayani / $totalDilayani) * 100; // Return percentage
    }

    public function getBelumTerlayaniAttribute()
    {
        $totalDilayani = $this->total_dilayani ?? 0; // Ensure it's not null
        $totalTerlayani = $this->total_terlayani; // Use the existing accessor

        return $totalDilayani - $totalTerlayani;
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
