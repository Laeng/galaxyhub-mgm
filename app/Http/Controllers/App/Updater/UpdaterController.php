<?php

namespace App\Http\Controllers\App\Updater;

use App\Enums\PermissionType;
use App\Http\Controllers\Controller;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use App\Services\File\Contracts\FileServiceContract;
use App\Services\Github\Contracts\GithubServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UpdaterController extends Controller
{
    private GithubServiceContract $githubService;

    public function __construct(GithubServiceContract $githubService)
    {
        $this->githubService = $githubService;
    }

    public function index(Request $request): view
    {
        return view('app.updater.index');
    }

    public function download(Request $request, FileServiceContract $fileService): RedirectResponse
    {
        $path = $fileService->getUrlToDirectly('do', 'mgm/updater', 'MGM UPDATER.exe', false, now()->addSeconds(15));

        return redirect()->to($path);
    }

    public function release(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'release' => 'bool'
            ]);

            if ($request->get('release', true))
            {
                $path = route('updater.download');
            }
            else
            {
                $path = '';
            }

            $github = $this->githubService->getLatestRelease('Laeng', 'MGM_UPDATER');

            $data = [
                'name' => $github['name'],
                'body' => $github['body'],
                'published_at' => Carbon::parse($github['published_at'])->format('Y-m-d'),
                'tag_name' => $github['tag_name'],
                'assets' => [
                    0 => [
                        'browser_download_url' => $path
                    ]
                ]
            ];

            return $this->jsonResponse(200, 'SUCCESS', $data);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), config('app.debug') ? $e->getTrace() : []);
        }
    }

    public function authorize_code(Request $request, string $code, UpdaterRepositoryInterface $updaterRepository): View
    {

        $validator = Validator::make($request->all(), [
            'name' => ['string', 'required']
        ]);

        $data = [
            'status' => false,
            'softwareName' => '',
            'machineName' => '',
            'machineIp' => ''
        ];

        if (!$validator->fails())
        {
            $user = Auth::user();
            $updater = $updaterRepository->findByMachineNameAndCode(base64_decode($request->get('name')), $code);

            if (!is_null($updater) && !$user->isBanned())
            {
                if ($user->hasPermissionTo(PermissionType::MEMBER->name))
                {
                    $updater->user_id = $user->id;
                    $updater->save();

                    $data = [
                        'status' => true,
                        'machineName' => $updater->machine_name,
                        'machineIp' => $updater->ip
                    ];
                }
            }
        }

        return view('app.account.authorize', $data);
    }
}
