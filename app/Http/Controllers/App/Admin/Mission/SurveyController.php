<?php

namespace App\Http\Controllers\App\Admin\Mission;

use App\Http\Controllers\Controller;
use App\Services\Survey\Questions\MissionQuestion;
use Illuminate\Contracts\View\View;


class SurveyController extends Controller
{
    public function survey(): View
    {
        $survey = [
            [
                'type' => 'section',
                'contents' => MissionQuestion::questionNotice()[0]
            ],
            [
                'type' => 'question',
                'contents' => MissionQuestion::questionPart1()
            ],
            [
                'type' => 'section',
                'contents' => MissionQuestion::questionNotice()[1]
            ],
        ];

        return view('app.admin.mission.survey', [
            'survey' => $survey
        ]);
    }
}
