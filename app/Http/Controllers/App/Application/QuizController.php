<?php

namespace App\Http\Controllers\App\Application;

use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use function redirect;
use function view;

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
        $user = Auth::user();

        if ($user->hasRole(RoleType::APPLY->name))
        {
            return redirect()->route('application.index');
        }

        if ($request->isMethod('get') && (is_null($request->session()->get('_old_input')) || count($request->session()->get('_old_input')) <= 0))
        {
            return redirect()->route('application.index');
        }

        $quizzes = $this->surveyService->getApplicationQuizWithIn7Days($user->id);

        if ($quizzes?->count() > 0 && $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $quizzes->first()->id)?->count() > 0)
        {
            return redirect()->route('application.score');
        }

        if ($user->isBanned())
        {
            return redirect()->route('account.suspended');
        }

        $quiz = $this->surveyService->createApplicationQuiz($user->id, $user->name);

        return view('app.application.quiz', [
            'survey' => $quiz,
            'action' => route('application.score')
        ]);
    }

    public function score(Request $request): View|Application|RedirectResponse|Redirector
    {
        $user = Auth::user();

        if ($user->hasRole(RoleType::APPLY->name))
        {
            return redirect()->route('application.index');
        }

        if ($request->isMethod('GET'))
        {
            $quizzes = $this->surveyService->getApplicationQuizWithIn7Days($user->id);

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
            $quiz = $this->surveyService->createApplicationQuiz($user->id, $user->name, $quizId);
        }

        $quizEntry = $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $quizId)?->first();

        if (is_null($quizEntry))
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
                        'comment' => 'ARMA3 퀴즈를 3개 이상 맞추지 못하셨습니다. 7일 후 다시 도전 하실 수 있습니다.',
                        'expired_at' => now()->addDays(7),
                    ]);
                }
            }
        }

        return view('app.application.score', [
            'user' => $user,
            'survey' => $quiz,
            'answer' => $quizEntry->id,
            'matches' => $matches
        ]);
    }
}
