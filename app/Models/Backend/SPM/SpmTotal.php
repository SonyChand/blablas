<?php

namespace App\Models\Backend\SPM;

use App\Models\Backend\SPM\Tahun;
use App\Models\Backend\SPM\Puskesmas;
use App\Models\Backend\SPM\SubLayanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpmTotal extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'spm_total';

    // Specify the fillable fields
    protected $fillable = [
        'puskesmas_id',
        'sub_layanan_id',
        'tahun_id',
        'total_dilayani',
        'terlayani',
        'belum_terlayani',
        'pencapaian',
    ];


    // Define relationships
    public function spm()
    {
        return $this->belongsTo(Spm::class, 'spm_id');
    }
}
