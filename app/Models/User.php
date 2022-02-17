<?php

namespace App\Models;

use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Sanctum\HasApiTokens;
use QCod\Gamify\Gamify;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Gamify, Bannable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'visit',
        'avatar',
        'provider',
        'username',
        'password',
        'agreed_at',
        'visited_at'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'agreed_at' => 'datetime',
        'banned_at' => 'datetime',
        'verified_at' => 'datetime',
        'visited_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const RECORD_STEAM_DATA_SUMMARIES = 'STEAM_DATA_SUMMARIES';
    const RECORD_STEAM_DATA_GAMES = 'STEAM_DATA_GAMES';
    const RECORD_STEAM_DATA_ARMA3 = 'STEAM_DATA_ARMA3';
    const RECORD_STEAM_DATA_BANS = 'STEAM_DATA_BANS';
    const RECORD_STEAM_DATA_GROUPS = 'STEAM_DATA_GROUPS';


    const ROLE_APPLY = 'APPLY';
    const ROLE_DEFER = 'DEFER';
    const ROLE_REJECT = 'REJECT';
    const ROLE_MEMBER = 'MEMBER';
    const ROLE_MAKER1 = 'MAKER1';
    const ROLE_MAKER2 = 'MAKER2';
    const ROLE_STAFF = 'STAFF';

    const PERMISSION_MEMBER = 'MEMBER';
    const PERMISSION_MAKER1 = 'MAKER1';
    const PERMISSION_MAKER2 = 'MAKER2';
    const PERMISSION_STAFF = 'STAFF';

    private array $roleNames = [
        '가입 신청' => self::ROLE_APPLY,
        '가입 보류' => self::ROLE_DEFER,
        '가입 거절' => self::ROLE_REJECT,
        '멤버' => self::ROLE_MEMBER,
        '임시 메이커' => self::ROLE_MAKER1,
        '정식 메이커' => self::ROLE_MAKER2,
        '관리자' => self::ROLE_STAFF
    ];

    private array $permissionNames = [
        '멤버' => self::PERMISSION_MEMBER,
        '임시 메이커' => self::PERMISSION_MAKER1,
        '정식 메이커' => self::PERMISSION_MAKER2,
        '관리자' => self::PERMISSION_STAFF
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(UserAccount::class);
    }

    public function surveys(): HasMany
    {
        return $this->hasMany(SurveyEntry::class, 'participant_id');
    }
}
