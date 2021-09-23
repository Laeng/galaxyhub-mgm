<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['value', 'question_id', 'entry_id'];

    /**
     * The entry the answer belongs to.
     *
     * @return BelongsTo
     */
    public function entry(): BelongsTo
    {
        return $this->belongsTo(SurveyEntry::class);
    }

    /**
     * The question the answer belongs to.
     *
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class);
    }
}
