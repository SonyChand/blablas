<?php

namespace App\Models\Managements\Letters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialTaskFile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'letter_type',
        'letter_number',
        'letter_reference',
        'letter_date',
        'assign',
        'to_implement',
        'letter_closing',
        'letter_creation_date',
        'signed_by',
        'attachment',
        'operator_name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'letter_date' => 'date',
        'letter_creation_date' => 'date',
    ];
}
