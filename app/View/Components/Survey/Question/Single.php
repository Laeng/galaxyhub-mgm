<?php

namespace App\View\Components\Survey\Question;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Single extends Component
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
     * @return Application|Factory|View
     */
    public function render(): Application|Factory|View
    {
        $type = 'text';
        if (view()->exists("components.survey.question.type.{$this->question->type}")) {
            $type = $this->question->type;
        }

        return view('components.survey.question.single', ['question' => $this->question, 'type' => $type]);
    }
}
