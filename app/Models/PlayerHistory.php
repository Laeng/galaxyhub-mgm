<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlayerHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'staff_id',
        'type',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function staff(): hasOne
    {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }
}
