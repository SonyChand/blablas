<?php

namespace App\Models\Backend\SPM;

use App\Models\Backend\SPM\Spm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Puskesmas extends Model
{
    use HasFactory;

    protected $table = 'puskesmas';

    protected $fillable = ['kode', 'nama', 'alamat'];

    public function spms()
    {
        return $this->hasMany(Spm::class, 'puskesmas_id');
    }
}
