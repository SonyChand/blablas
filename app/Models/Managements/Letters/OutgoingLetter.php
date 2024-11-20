<?php

namespace App\Models\Managements\Letters;

use Illuminate\Support\Str;
use App\Models\Managements\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutgoingLetter extends Model
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
        'letter_nature',
        'letter_subject',
        'letter_date',
        'letter_destination',
        'to',
        'letter_body',
        'event_date_start',
        'event_date_end',
        'event_time_start',
        'event_time_end',
        'event_location',
        'event_agenda',
        'letter_closing',
        'attachment',
        'operator_name',
        'file_path',
        'signed_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'letter_date' => 'date',
        'letter_destination' => 'array',
        'file_path' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'signed_by', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
