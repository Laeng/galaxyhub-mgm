<?php

namespace App\Action\Survey;

interface SurveyFormContract
{
    public function getJoinApplicationForm(): \App\Models\Survey;
    public function getMissionSurveyForm(): \App\Models\Survey;
}
