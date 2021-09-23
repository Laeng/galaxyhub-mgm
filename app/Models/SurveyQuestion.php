<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'options', 'title', 'content', 'rules', 'survey_id'];

    protected $casts = [
        'rules' => 'array',
        'options' => 'array',
    ];

    /**
     * Boot the question.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        //Ensure the question's survey is the same as the section it belongs to.
        static::creating(function (self $question) {
            $question->load('section');

            if ($question->section) {
                $question->survey_id = $question->section->survey_id;
            }
        });
    }

    /**
     * The survey the question belongs to.
     *
     * @return BelongsTo
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * The section the question belongs to.
     *
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(SurveySection::class);
    }

    /**
     * The answers that belong to the question.
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(SurveyAnswer::class);
    }

    /**
     * The question's validation rules.
     *
     * @param $value
     * @return array|null
     */
    public function getRulesAttribute($value): ?array
    {
        $value = $this->castAttribute('rules', $value);

        return $value !== null ? $value : [];
    }

    /**
     * The unique key representing the question.
     *
     * @return string
     */
    public function getKeyAttribute(): string
    {
        return "q{$this->id}";
    }

    /**
     * Scope a query to only include questions that
     * don't belong to any sections.
     *
     * @param $query
     * @return mixed
     */
    public function scopeWithoutSection($query): mixed
    {
        return $query->where('survey_section_id', null);
    }
}
