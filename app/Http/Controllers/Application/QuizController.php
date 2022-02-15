<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Services\Survey\Contracts\SurveyServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class QuizController extends Controller
{
    public function index(Request $request, SurveyServiceContract $surveyService): View|Application|RedirectResponse|Redirector
    {
        if($request->isMethod('get') && (is_null($request->session()->get('_old_input')) || count($request->session()->get('_old_input')) <= 0 ))
        {
            //return redirect()->route('application.index');
        }

        $user = $request->user();
        $quizzes = $surveyService->getLatestApplicationQuiz($user);

        if($quizzes->count() > 0 && $user->surveys()->where('survey_id', $quizzes->first()->id)->latest()->exists())
        {
            return redirect()->route('application.quiz.score');
        }

        $surveyModel = $surveyService->createApplicationQuiz($user);

        return view('user.application.quiz.index', [
            'survey' => $surveyModel,
            'action' => route('application.quiz.score')
        ]);
    }

    public function score(Request $request): View|Application|RedirectResponse|Redirector
    {
        return view('user.application.quiz.score');
    }
}
