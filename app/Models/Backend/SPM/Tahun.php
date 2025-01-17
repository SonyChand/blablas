<?php

namespace App\Models\Backend\SPM;

use App\Models\Backend\SPM\Spm;
use App\Models\Backend\SPM\PeriodeSPM;
use App\Models\Backend\SPM\SubLayanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tahun extends Model
{
    use HasFactory;

    protected $table = 'tahuns';

    protected $fillable = ['tahun'];

    public function subLayanans()
    {
        return $this->hasMany(SubLayanan::class, 'tahun_id');
    }

    public function spms()
    {
        return $this->hasMany(Spm::class, 'tahun_id');
    }

    public function periode()
    {
        return $this->hasMany(PeriodeSPM::class, 'tahun_id');
    }
}
