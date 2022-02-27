<?php

namespace App\Http\Controllers\App\Updater;

use App\Http\Controllers\Controller;
use App\Services\File\Contracts\FileServiceContract;
use App\Services\Github\Contracts\GithubServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpdaterController extends Controller
{
    private GithubServiceContract $githubService;

    public function __construct(GithubServiceContract $githubService)
    {
        $this->githubService = $githubService;
    }

    public function index(Request $request): view
    {
        $github = $this->githubService->getLatestRelease('Laeng', 'MGM_UPDATER');

        return view('app.updater.index');
    }

    public function download(Request $request, FileServiceContract $fileService): RedirectResponse
    {
        $path = $fileService->getUrlToDirectly('do', 'mgm/updater', 'MGM UPDATER.exe', false, now()->addSeconds(15));

        return redirect()->to($path);
    }
}
