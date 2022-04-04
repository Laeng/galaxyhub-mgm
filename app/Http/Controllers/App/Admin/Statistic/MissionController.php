<?php

namespace App\Http\Controllers\App\Admin\Statistic;

use App\Enums\MissionAddonType;
use App\Enums\MissionPhaseType;
use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\MissionRepository;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MissionController extends Controller
{
    private array $statisticMissionValues;

    public function mission(Request $request, UserRepositoryInterface $userRepository): View
    {
        $makers = $userRepository->new()->newQuery()->select(['id', 'name'])->Role([RoleType::MAKER1->name, RoleType::MAKER2->name, RoleType::ADMIN->name])->get();

        return view('app.admin.statistic.mission', [
            'makers' => $makers
        ]);
    }

    public function data(Request $request, MissionRepository $missionRepository): JsonResponse
    {
        try
        {
            $this->validate($request, [
                'query' => 'array'
            ]);

            $this->statisticMissionValues = [];

            $q = $request->get('query', []);
            $query = $missionRepository->new()->newQuery()->whereNotIn('phase', [MissionPhaseType::CANCEL->value]);

            $start = empty($q['start']) ? \Carbon\Carbon::createFromFormat('Y-m-d', "2020-01-01") : \Carbon\Carbon::createFromFormat('Y-m-d', "{$q['start']}");
            $end = empty($q['end']) ? today() : \Carbon\Carbon::createFromFormat('Y-m-d', "{$q['end']}");

            if (!empty($q['user_id']))
            {
                $query = $query->where('user_id', $q['user_id']);
            }

            $query = $query->whereBetween('started_at', [$start, $end])->latest('started_at')->with(['participants', 'user']);

            $query->chunk(100, function ($missions)
            {
                foreach ($missions as $mission)
                {
                    $maker = $mission->user;
                    $participants = $mission->participants;

                    $this->statisticMissionValues[] = [
                        'id' => $mission->id,
                        'title' => $mission->title,
                        'user_id' => $maker->id,
                        'user_name' => $maker->name,
                        'participants' => $participants->count(),
                        'attenders' => $participants->filter(function ($v, $k) {
                            return !is_null($v->attended_at);
                        })->count()
                    ];
                }
            });

            return $this->jsonResponse('200', 'success', [
                'data' => [
                    'total' => $query->count(),
                    'values' => $this->statisticMissionValues
                ]
            ]);

        }
        catch (Exception $e)
        {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), config('app.debug') ? $e->getTrace() : []);
        }
    }
}
