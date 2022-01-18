<?php

namespace App\Models;

use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements BannableContract
{
    use HasFactory, Notifiable, Bannable;

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
        'visit',
        'agreed_at',
        'visited_at'
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
        'agreed_at' => 'datetime',
        'visited_at' => 'datetime',

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

    public function surveys(): HasMany
    {
        return $this->hasMany(SurveyEntry::class, 'participant_id');
    }

    public function missions(): HasMany
    {
        return $this->hasMany(UserMission::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
