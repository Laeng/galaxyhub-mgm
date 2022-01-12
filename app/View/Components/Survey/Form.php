<?php

namespace App\View\Components\Survey;

use App\Models\Survey;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Form extends Component
{
    public Survey $survey;
    public string $action;
    public string $class;
    public string $submitText;
    public ?int $answer;
    public string $backText;
    public ?string $backLink;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Survey $survey, string $action, string $class = '', string $submitText = '제출', ?int $answer = null, string $backText = '돌아가기', ?string $backLink = null)
    {
        $this->survey = $survey;
        $this->action = $action;
        $this->class = $class;
        $this->submitText = $submitText;
        $this->answer = $answer;
        $this->backText = $backText;
        $this->backLink = $backLink;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): Application|Factory|View
    {
        return view('components.survey.form');
    }
}
