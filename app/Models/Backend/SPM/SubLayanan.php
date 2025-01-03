<?php

namespace App\Models\Backend\SPM;

use App\Models\Backend\SPM\Spm;
use App\Models\Backend\SPM\Tahun;
use App\Models\Backend\SPM\Layanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubLayanan extends Model
{
    use HasFactory;

    protected $table = 'sub_layanans';

    protected $fillable = ['layanan_id', 'kode', 'uraian', 'satuan', 'versi', 'catatan'];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function spms()
    {
        return $this->hasMany(Spm::class, 'sub_layanan_id');
    }
}
