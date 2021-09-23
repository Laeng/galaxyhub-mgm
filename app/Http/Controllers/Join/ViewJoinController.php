<?php

namespace App\Http\Controllers\Join;

use App\Action\Survey\SurveyForm;
use App\Action\Group\Group;
use App\Http\Controllers\Controller;
use App\Models\SurveyEntry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Syntax\SteamApi\Facades\SteamApi;

class ViewJoinController extends Controller
{
    public function agree(Request $request, Group $group): Factory|View|Application|RedirectResponse
    {
        if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
            return redirect()->route('lounge.index');
        }

        return view('join.agree');
    }

    public function apply(Request $request, Group $group, SurveyForm $form): Factory|View|Application|RedirectResponse
    {
        if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
            return redirect()->route('lounge.index');
        }

        if ($request->isMethod('get') && (is_null($request->session()->get('_old_input')) || count($request->session()->get('_old_input')) <= 0 )) {
            return redirect()->route('join.agree');
        }

        $survey = $form->getJoinApplicationForm();

        return view('join.apply', ['survey' => $survey, 'action' => route('join.submit')]);
    }

    public function submit(Request $request, Group $group, SurveyForm $form): RedirectResponse
    {
        if ($group->has([$group::ARMA_MEMBER, $group::BANNED, $group::ARMA_APPLY])) {
            return redirect()->route('lounge.index');
        }

        $survey = $form->getJoinApplicationForm();
        $answers = $this->validate($request, $survey->validateRules());

        (new SurveyEntry())->for($survey)->by(auth()->user())->fromArray($answers)->push();

        auth()->user()->update(['agreed_at', now()]);
        $group->create($group::ARMA_APPLY);

        return redirect()->route('lounge.index');
    }
}
