<?php

namespace App\View\Components\Survey\Question\Type;

use App\Models\SurveyQuestion;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\View\Component;

class Number extends Component
{
    public SurveyQuestion $question;
    public int|null $answer;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(SurveyQuestion $question, int|null $answer = null)
    {
        $this->question = $question;

        if (!is_null($answer)) {
            $value = $question->answers()->where('survey_entry_id', $answer)->first();
            $this->answer = is_null($value) ? '응답하지 않음' : $value->value;
        } else {
            $this->answer = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.survey.question.type.number');
    }
}
