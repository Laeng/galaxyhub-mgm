<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Services\Survey\Contracts\SurveyServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class FormController extends Controller
{
    public SurveyServiceContract $surveyService;

    public function __construct(SurveyServiceContract $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function index(Request $request): View|Application|RedirectResponse|Redirector
    {
        if ($request->isMethod('get') && (is_null($request->session()->get('_old_input')) || count($request->session()->get('_old_input')) <= 0 )) {
            return redirect()->route('application.agreements');
        }

        $form = $this->surveyService->createApplicationForm();

        return view('user.application.form.index', [
            'survey' => $form,
            'action' => route('application.store')
        ]);
    }

    public function store(Request $request): View|Application|RedirectResponse|Redirector
    {

    }
}
