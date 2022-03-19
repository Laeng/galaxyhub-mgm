<?php

namespace App\Http\Controllers\App\Admin\Broadcast;

use App\Repositories\User\Interfaces\UserAccountRepositoryInterface;
use App\Services\Naver\Contracts\NaverServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use function redirect;
use function route;
use function view;

class NaverController
{
    private NaverServiceContract $naverService;

    public function __construct(NaverServiceContract $naverService)
    {
        $this->naverService = $naverService;
    }

    public function authorizeCode(): RedirectResponse
    {
        return redirect()->to($this->naverService->getAuthorizeUrl(route('admin.broadcast.naver.callback')));
    }

    public function callback(Request $request):RedirectResponse
    {
        try
        {
            $account = $this->naverService->authorizationCode($request, 0);
        }
        catch (\Exception $e)
        {

        }

        return redirect()->route('admin.broadcast.naver.index');
    }

    public function index(Request $request, UserAccountRepositoryInterface $userAccountRepository): View
    {
        $userAccount = $userAccountRepository->findNaverAccountByUserId(0)->first();

        return view('app.admin.broadcast.naver.index', [
            'account' => $userAccount,
        ]);
    }

}
