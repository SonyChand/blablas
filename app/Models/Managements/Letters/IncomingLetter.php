<?php

namespace App\Models\Managements\Letters;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class IncomingLetter extends Model
{
    protected $fillable = [
        'uuid',
        'source_letter',
        'addressed_to',
        'letter_number',
        'letter_date',
        'subject',
        'attachment',
        'forwarded_disposition',
        'file_path',
        'operator_name',
    ];

    protected $hidden = [
        'uuid',
    ];

    protected function casts(): array
    {
        return [
            'letter_date' => 'date',
            'source_letter' => 'array',
            'addressed_to' => 'array',
            'forwarded_disposition' => 'array',
            'file_path' => 'array',
        ];
    }
    public function dispositions()
    {
        return $this->hasMany(Disposition::class, 'letter_id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
