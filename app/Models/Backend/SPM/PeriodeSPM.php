<?php

namespace App\Models\Backend\SPM;

use App\Models\Backend\SPM\Spm;
use App\Models\Backend\SPM\Tahun;
use App\Models\Backend\SPM\SubLayanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodeSPM extends Model
{
    use HasFactory;

    protected $table = 'periode_spms';

    protected $fillable = ['tahun_id', 'periode_awal', 'periode_akhir'];


    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun_id');
    }
}
