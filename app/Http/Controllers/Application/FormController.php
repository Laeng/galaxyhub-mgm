<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Repositories\Survey\SurveyEntryRepository;
use App\Repositories\User\UserAccountRepository;
use App\Services\Steam\Contracts\SteamServiceContract;
use App\Services\Survey\Contracts\SurveyServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public SurveyServiceContract $surveyService;

    public function __construct(SurveyServiceContract $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function index(Request $request): View|Application|RedirectResponse|Redirector
    {
        if ($request->isMethod('get') && (is_null($request->session()->get('_old_input')) || count($request->session()->get('_old_input')) <= 0 ))
        {
            return redirect()->route('application.agreements');
        }

        $form = $this->surveyService->createApplicationForm();

        return view('user.application.form', [
            'survey' => $form,
            'action' => route('application.store')
        ]);
    }

    public function store(Request $request, SurveyEntryRepository $surveyEntryRepository, UserAccountRepository $accountRepository, SteamServiceContract $steamService): View|Application|RedirectResponse|Redirector
    {
        $form = $this->surveyService->createApplicationForm();
        $answers = $this->validate($request, $form->validateRules());

        $user = Auth::user();
        $accounts = $accountRepository->findByUserId($user->id);
        $steamAccount = $accounts->filter(fn ($v, $k) => $v->provider === 'steam')->first();

        $steamPlayerSummaries = $steamService->getPlayerSummaries($steamAccount->account_id);

        if ($steamPlayerSummaries['response']['players'][0]['communityvisibilitystate'] != 3)
        {
            return redirect()->back()->withErrors(['error' => '스팀 프로필이 친구 공개 또는 비공개 상태입니다. 프로필을 공개로 변경해 주십시오.']);
        }

        //TODO - queue

        $surveyEntryRepository->new()->for($form)->by($user)->fromArray($answers)->push();

        $now = now();
        $user->update([
            'created_at' => $now,
            'agreed_at' => $now
        ]);

        return redirect()->route('application.apply')->withErrors(['success' => '가입 신청이 접수되었습니다.']);
    }
}
