<?php

namespace App\View\Components\Survey\Question\Type;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Text extends Component
{
    public SurveyQuestion $question;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(SurveyQuestion $question)
    {
        $this->question = $question;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.survey.question.type.text', ['question' => $this->question]);
    }
}
