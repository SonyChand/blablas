<?php

namespace App\Models\Managements\Letters;

use App\Models\Managements\Letters\IncomingLetter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'letter_id',
        'letter_number',
        'from',
        'type',
        'disposition_to',
        'notes',
        'disposition_date',
        'signed_by',
    ];

    protected $hidden = [
        'uuid',
    ];

    protected function casts(): array
    {
        return [
            'disposition_date' => 'date',
            'disposition_to' => 'array',
        ];
    }

    public function letter()
    {
        return $this->belongsTo(IncomingLetter::class, 'letter_id');
    }
}
