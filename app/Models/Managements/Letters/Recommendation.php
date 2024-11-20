<?php

namespace App\Models\Managements\Letters;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recommendation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'recommendation_type',
        'recommendation_number',
        'basis_of_recommendation',
        'recommendation_consideration',
        'recommended_data',
        'recommendation_purpose',
        'recommendation_closing',
        'recommendation_date',
        'signed_by',
        'operator_name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'recommendation_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
