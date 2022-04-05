<?php

namespace App\Http\Controllers\App\Application;

use App\Enums\BanCommentType;
use App\Enums\RoleType;
use App\Enums\UserRecordType;
use App\Http\Controllers\Controller;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use App\Repositories\User\Interfaces\UserRecordRepositoryInterface;
use App\Services\Survey\Contracts\SurveyServiceContract;
use App\Services\User\Contracts\UserServiceContract;
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

    public function score(Request $request, UserServiceContract $userService): View|Application|RedirectResponse|Redirector
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

            $quizEntry = $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $quizId)->first();
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

        $isPost = false;
        $rejectCount = $userService->findRoleRecordeByUserId($user->id, RoleType::REJECT->name, true)->count();

        if ($request->isMethod('POST')) {
            $isPost = true;

            if ($matches < 4)
            {
                $quizzes = $this->surveyService->getApplicationQuiz($user->id);

                if ($quizzes->count() >= 2)
                {
                    $banDays = null;

                    switch ($rejectCount)
                    {
                        case 0:
                            $banReason = '가입 퀴즈 2회 불합격';
                            $banDays = 30;
                            break;

                        case 1:
                            $banReason = '가입 퀴즈 3회 불합격';
                            $banDays = 90;
                            break;

                        default:
                            $banReason = '가입 퀴즈 4회 이상 불합격';
                            break;
                    }

                    $rejectCount += 1;

                    if (!is_null($user->bans()) && $user->bans()->first()->comment !== $banReason)
                    {
                        $roles = $user->getRoleNames();

                        foreach ($roles as $role)
                        {
                            $user->removeRole($role);
                        }

                        $user->assignRole(RoleType::REJECT->name);

                        $banType = is_null($banDays) ? ['무기한', '더 이상 가입 신청을 하실 수 없습니다.'] : ['일시', "{$banDays}일 이후 가입 신청을 하실 수 있습니다."];

                        $user->ban([
                            'comment' => "가입이 {$rejectCount}번 거절되어 계정이 {$banType[0]} 비활성 되었습니다. {$banType[1]}<br/><br/><span class='font-bold'>가입 거절 사유:</span><br/>{$banReason}",
                            'expired_at' => !is_null($banDays) ? now()->addDays($banDays) : null
                        ]);

                        $userService->createRecord($user->id, UserRecordType::ROLE_DATA->name, [
                            'role' => RoleType::REJECT->name,
                            'comment' => $banReason
                        ]);
                    }
                }
                else
                {
                    $userService->ban($user->id, '가입 퀴즈 불합격', 7);
                }
            }
        }

        if ($user->isBanned() || $isPost)
        {
            $pauseDays = match ($rejectCount) {
                0 => 7,
                1 => 30,
                2 => 90,
                default => null
            };
        }
        else
        {
            $pauseDays = 0;
        }

        return view('app.application.score', [
            'user' => $user,
            'survey' => $quiz,
            'answer' => $quizEntry->id,
            'matches' => $matches,
            'pauseDays' => $pauseDays
        ]);
    }
}
