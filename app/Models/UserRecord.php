<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staff_id',
        'type',
        'data',
        'uuid'
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function staff():BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'staff_id');
    }
}
