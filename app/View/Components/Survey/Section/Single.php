<?php

namespace App\View\Components\Survey\Section;

use App\Models\Survey;
use App\Models\SurveySection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Single extends Component
{
    public SurveySection $section;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(SurveySection $section)
    {
        $this->section = $section;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): Application|Factory|View
    {
        return view('components.survey.section.single');
    }
}
