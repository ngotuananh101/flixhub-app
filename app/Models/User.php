<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'username',
        'email',
        'google_id',
        'facebook_id',
        'email_verified_at',
        'password',
        'last_login_at',
        'is_active',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
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
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Override the boot method of the model.
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if(empty($model->avatar)) {
                $model->avatar = 'https://ui-avatars.com/api/?background=random&size=256&name=' . $model->username;
            }
        });

        static::created(function ($model) {
            $defaultRole = Role::where('is_default', true)->first();
            if ($defaultRole) {
                $model->assignRole($defaultRole);
            }
        });
    }

    /**
     * Getter
     */
    public function getAvatarAttribute($value): string
    {
        return $value ?? 'https://ui-avatars.com/api/?background=random&size=256&name=' . $this->username;
    }
}
