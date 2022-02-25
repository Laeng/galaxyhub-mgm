<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'storage',
        'path',
        'filename',
        'extension',
        'name',
        'visible'
    ];

    protected $casts = [
        'visible' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
