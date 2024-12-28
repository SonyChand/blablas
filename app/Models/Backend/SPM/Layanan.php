<?php

namespace App\Models\Backend\SPM;

use App\Models\Backend\SPM\SubLayanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanans';

    protected $fillable = ['kode', 'nama'];

    public function subLayanans()
    {
        return $this->hasMany(SubLayanan::class, 'layanan_id');
    }
}
