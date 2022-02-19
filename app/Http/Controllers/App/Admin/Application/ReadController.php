<?php

namespace App\Http\Controllers\App\Admin\Application;

use App\Http\Controllers\Controller;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    public function read(Request $request, int $userId, UserRepositoryInterface $userRepository, SurveyServiceContract $surveyService)
    {
        $applicant = $userRepository->findById($userId);

        if (is_null($applicant))
        {
            abort('404');
        }

        $application = $surveyService->getLatestApplicationForm($applicant->id);
        $survey = $application->survey()->first();

        if (is_null($application))
        {
            abort(404);
        }





        return view('app.admin.application.read', [
            'applicant' => $applicant,
            'title' => "{$applicant->name}님의 신청서",
            'survey' => $survey,
            'answer' => $application->id
        ]);
    }
}
