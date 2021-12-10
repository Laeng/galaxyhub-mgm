<?php

namespace App\Action\Survey;

use App\Models\Mission;

interface SurveyFormContract
{
    public function getJoinApplicationForm(): \App\Models\Survey;
    public function getMissionSurveyForm(Mission $mission): \App\Models\Survey;
}
