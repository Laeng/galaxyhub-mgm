<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'provider',
        'username',
        'nickname',
        'password',
        'avatar',
        'remember_token',
        'email',
        'agreed_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function socials(): HasMany
    {
        return $this->hasMany(UserSocial::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(UserGroup::class);
    }

    public function data(): HasMany
    {
        return $this->hasMany(UserData::class);
    }
}
