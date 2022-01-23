<?php

namespace App\Action\Survey;

use App\Models\Mission;

interface SurveyFormContract
{
    public function getJoinApplication(): \App\Models\Survey;
    public function getMissionSurvey(Mission $mission): \App\Models\Survey;
}
