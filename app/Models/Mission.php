<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'survey_id',
        'type',
        'phase',
        'code',
        'title',
        'body',
        'data',
        'can_tardy',
        'count',
        'expected_at',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'expected_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'data' => 'array'
    ];

    public function maker(): HasOne
    {
        return $this->HasOne(User::class, 'id', 'user_id');
    }
}
