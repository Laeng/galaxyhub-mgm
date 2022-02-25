<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AppController extends Controller
{
    public function index(): View|Application|RedirectResponse|Redirector
    {
        return view('app.index');
    }

    public function privacy()
    {

    }

    public function rules()
    {

    }
}
