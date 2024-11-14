<?php

namespace App\Models\Managements;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $fillable = [
        'uuid',
        'user_id',
        'email',
        'name',
        'employee_type',
        'employee_identification_number',
        'birth_place',
        'birth_date',
        'rank_start_date',
        'rank',
        'position_start_date',
        'position',
        'education_level',
        'education_institution',
        'major',
        'graduation_date',
        'work_unit'
    ];

    protected $hidden = [
        'uuid',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'rank_start_date' => 'date',
            'position_start_date' => 'date',
            'graduation_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
