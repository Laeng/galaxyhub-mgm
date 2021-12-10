<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function getTypeName(): ?string
    {
        return match ($this->type) {
            0 => '아르마의 밤',
            1 => '일반 미션',
            default => null
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(UserMission::class);
    }
}
