<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    private SurveyServiceContract $surveyService;
    private SurveyEntryRepositoryInterface $surveyEntryRepository;

    public function __construct(SurveyServiceContract $surveyService, SurveyEntryRepositoryInterface $surveyEntryRepository)
    {
        $this->surveyService = $surveyService;
        $this->surveyEntryRepository = $surveyEntryRepository;
    }

    public function index(Request $request): View|Application|RedirectResponse|Redirector
    {
        if($request->isMethod('get') && (is_null($request->session()->get('_old_input')) || count($request->session()->get('_old_input')) <= 0 ))
        {
            return redirect()->route('application.index');
        }

        $user = $request->user();
        $quizzes = $this->surveyService->getLatestApplicationQuiz($user);

        if($quizzes?->count() > 0 && $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $quizzes->first()->id)?->count() > 0)
        {
            return redirect()->route('application.quiz.score');
        }

        $quiz = $this->surveyService->createApplicationQuiz($user);

        return view('user.application.quiz.index', [
            'survey' => $quiz,
            'action' => route('application.quiz.score')
        ]);
    }

    public function score(Request $request): View|Application|RedirectResponse|Redirector
    {
        $user = $request->user();

        if($request->isMethod('GET'))
        {
            $quizzes = $this->surveyService->getLatestApplicationQuiz($user);

            if($quizzes->count() == 0)
            {
                return redirect()->route('application.index');
            }

            $quiz = $quizzes->first();
            $quizId = $quiz->id;
        }
        else
        {
            $quizId = $request->get('id');
            $quiz = $this->surveyService->createApplicationQuiz($user, $quizId);
        }

        $quizEntry = $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $quizId)?->first();

        if(is_null($quizEntry))
        {
            $answers = $this->validate($request, $quiz->validateRules());
            $this->surveyEntryRepository->new()->for($quiz)->by($user)->fromArray($answers)->push();

            $quizEntry = $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $quizId)?->first();
        }

        $answers = $quizEntry->answers()->get();
        $matches = 0;

        foreach ($answers as $answer)
        {
            $options = $answer->question()->first()->options;

            if (end($options) === $answer->value) {
                $matches++;
            }
        }

        if ($request->isMethod('POST')) {
            if ($matches < 3) {
                if (!$user->isBanned()) {
                    $user->ban([
                        'comment' => '가입 퀴즈를 3개 이상 맞추지 못하셨습니다. 7일 후 다시 도전 하실 수 있습니다.',
                        'expired_at' => '+7 days',
                    ]);
                }
            }
        }

        return view('user.application.quiz.score', [
            'user' => $user,
            'survey' => $quiz,
            'answer' => $quizEntry->id,
            'matches' => $matches
        ]);
    }
}
