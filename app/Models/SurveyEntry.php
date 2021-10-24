<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyEntry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['survey_id', 'participant_id'];

    /**
     * The answers within the entry.
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(SurveyAnswer::class);
    }

    /**
     * The survey the entry belongs to.
     *
     * @return BelongsTo
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * The participant that the entry belongs to.
     *
     * @return BelongsTo
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    /**
     * Set the survey the entry belongs to.
     *
     * @param Survey $survey
     * @return $this
     */
    public function for(Survey $survey): static
    {
        $this->survey()->associate($survey);

        return $this;
    }

    /**
     * Set the participant who the entry belongs to.
     *
     * @param Model|null $model
     * @return $this
     */
    public function by(Model $model = null): static
    {
        $this->participant()->associate($model);

        return $this;
    }

    /**
     * Create an entry from an array.
     *
     * @param array $values
     * @return $this
     */
    public function fromArray(array $values): static
    {
        foreach ($values as $key => $value) {
            if ($value === null) {
                continue;
            }

            $this->answers->add(SurveyAnswer::make([
                'survey_question_id' => substr($key, 1),
                'survey_entry_id' => $this->id,
                'value' => clean($value), //using mews/purifier
            ]));
        }

        return $this;
    }

    /**
     * The answer for a given question.
     *
     * @param SurveyQuestion $question
     * @return mixed
     */
    public function answerFor(SurveyQuestion $question): mixed
    {
        $answer = $this->answers()->where('question_id', $question->id)->first();

        return isset($answer) ? $answer->value : null;
    }

    /**
     * Save the model and all of its relationships.
     * Ensure the answers are automatically linked to the entry.
     *
     * @return bool
     */
    public function push(): bool
    {
        $this->save();

        foreach ($this->answers as $answer) {
            $answer->survey_entry_id = $this->id;
        }

        return parent::push();
    }

}
