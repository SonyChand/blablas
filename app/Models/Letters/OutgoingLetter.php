<?php

namespace App\Models\Letters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingLetter extends Model
{
    use HasFactory;
    protected $fillable = [
        'letter_type',
        'letter_number',
        'letter_nature',
        'letter_subject',
        'letter_date',
        'letter_destination',
        'to',
        'letter_body',
        'letter_closing',
        'sign_name',
        'sign_nip',
        'sign_position',
        'attachment',
        'operator_name',
    ];
}
