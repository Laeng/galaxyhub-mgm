<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateSteamAccounts;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\User\Interfaces\UserMissionRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\matches;

class AppController extends Controller
{
    public function __construct()
    {

    }

    public function index
    (
        Request $request, MissionRepositoryInterface $missionRepository,
        UserMissionRepositoryInterface $userMissionRepository
    ): View
    {
        $user = Auth::user();
        $attendUserMission = $userMissionRepository->findAttendedMissionByUserId($user->id, ['*'], ['mission'])->first();
        $latestUserMission = $userMissionRepository->findByUserId($user->id, ['*'], ['mission'])->first();
        $latestMission = $missionRepository->findBetweenDates('expected_at', [today(), today()->addYear()])->first(fn ($v, $k) => $v->phase === 0);

        return view('app.index', [
            'user' => Auth::user(),
            'latestMission' => $latestMission,
            'attendUserMission' => $attendUserMission,
            'latestUserMission' => $latestUserMission

        ]);
    }

    public function privacy(?int $date = null): View
    {
        $path = match ($date) {
            220301 => 'components.agreements.privacy_220301',
            default => 'components.agreements.privacy'
        };

        return view('app.privacy', [
            'path' => $path
        ]);
    }

    public function rules(): View
    {
        return view('app.rules');
    }

}
