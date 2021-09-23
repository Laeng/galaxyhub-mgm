<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'social_provider',
        'social_id',
        'social_email',
        'social_name',
        'social_avatar',
        'social_nickname',
        'refresh_token',
        'access_token'
    ];
}
