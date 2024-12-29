<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Backend\SPM\Spm;
use App\Models\Backend\SPM\Puskesmas;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'gender',
        'date_of_birth',
        'whatsapp',
        'picture',
        'puskesmas_id',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'uuid',
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function spmUpdate()
    {
        return $this->hasMany(Spm::class, 'id', 'updated_by');
    }

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id');
    }

    public function getMaskedEmailAttribute()
    {
        $parts = explode('@', $this->email);
        $username = substr($parts[0], 0, 2) . str_repeat('*', strlen($parts[0]) - 2);
        $domain = explode('.', $parts[1]);
        $domain = $domain[0] . '.' . (isset($domain[1]) ? $domain[1] : '');
        return $username . '@' . $domain;
    }
}
