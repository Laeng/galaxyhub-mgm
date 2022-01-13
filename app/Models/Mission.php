<?php

namespace App\Models;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mission extends Model
{
    use HasFactory;

    public static array $typeNames = [
        0 => '아르마의 밤',
        1 => '미션',
        2 => '논미메',
        10 => '부트캠프',
        11 => '약장 시험',
    ];

    public static int $attendTerm = 12; // 미션 종료 후 12시간 동안 출석 가능
    public static int $attendTry = 5; // 출석 시도 5회까지 허용

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
        'closed_at'
    ];

    protected $casts = [
        'type' => 'integer',
        'phase' => 'integer',
        'code' => 'string', //0000 ~ 9999 를 지원하기 위해서
        'count' => 'integer',
        'can_tardy' => 'boolean', // 사용 하지 않음.
        'expected_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'closed_at' => 'datetime',
        'data' => 'array'
    ];

    public function getTypeName(): ?string
    {
        if (array_key_exists($this->type, self::$typeNames)) {
            return self::$typeNames[$this->type];
        } else {
            return null;
        }
    }

    public function getPhaseName(): ?string
    {
        return match($this->phase) {
            -1 => '취소',
            0 => '모집 중',
            1 => '진행 중',
            2 => '출석 중',
            3 => '종료',
            default => ''
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

    public function survey(): HasOne
    {
        return $this->hasOne(Survey::class, 'id', 'survey_id');
    }
}
