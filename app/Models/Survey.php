<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'settings', 'user_id'];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
        'created_at' => 'datetime'
    ];

    /**
     * The survey sections.
     *
     * @return HasMany
     */
    public function sections(): HasMany
    {
        return $this->hasMany(SurveySection::class);
    }

    /**
     * The survey questions.
     *
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    /**
     * The survey entries.
     *
     * @return HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(SurveyEntry::class);
    }

    /**
     * Survey entries by a participant.
     *
     * @param Model $participant
     * @return HasMany
     */
    public function entriesFrom(Model $participant): HasMany
    {
        return $this->entries()->where('participant_id', $participant->id);
    }

    /**
     * Last survey entry by a participant.
     *
     * @param Model|null $participant
     * @return HasMany|null
     */
    public function lastEntry(Model $participant = null): ?HasMany
    {
        return $participant === null ? null : $this->entriesFrom($participant)->first();
    }

    /**
     * Combined validation rules of the survey.
     *
     * @return mixed
     */
    public function getRulesAttribute(): mixed
    {
        return $this->questions->mapWithKeys(function ($question) {
            return [$question->key => $question->rules];
        })->all();
    }

    public function validateRules(): array
    {
        $rules = [];
        $questions = [];

        $sections = $this->sections()->with('questions')->get()->toArray();
        foreach ($sections as $section) {
            $questions = array_merge($questions, $section['questions']);
        }

        $questions = array_merge($questions, $this->questions()->get()->toArray());

        foreach ($questions as $q) {
            $rules = array_merge($rules, ["q{$q['id']}" => $q['rules']]);
        }

        return $rules;
    }
}
