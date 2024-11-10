<?php

namespace App\Models\Letters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    use HasFactory;
    protected $fillable = [
        'letter_id',
        'from',
        'type',
        'disposition_to',
        'notes',
        'disposition_date',
        'sign',
    ];
}
