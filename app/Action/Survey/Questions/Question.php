<?php

namespace App\Action\Survey\Questions;

use App\Models\Survey as SurveyModel;

abstract class Question
{
    protected SurveyModel $survey;

    public function __construct(SurveyModel $survey)
    {
        $this->survey = $survey;
    }

    abstract public function create(...$vars): SurveyModel;

}
