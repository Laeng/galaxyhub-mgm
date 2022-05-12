<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'data'
    ];

    protected $casts = [
        'type' => 'string',
        'data' => 'array'
    ];
}
