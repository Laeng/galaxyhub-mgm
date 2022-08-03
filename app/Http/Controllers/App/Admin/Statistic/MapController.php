<?php

namespace App\Http\Controllers\App\Admin\Statistic;

use App\Enums\MissionMapType;
use App\Enums\MissionPhaseType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\MissionRepository;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MapController extends Controller
{
    private array $statisticMap;
    private array $statisticMapValues;

    public function map(Request $request): View
    {
        return view('app.admin.statistic.map');
    }

    public function data(Request $request, MissionRepository $missionRepository): JsonResponse
    {
        try
        {
            $this->validate($request, [
                'query' => 'array'
            ]);

            $this->statisticMap = [];
            $this->statisticMapValues = [];

            $q = $request->get('query', []);
            $start = empty($q['start']) ? \Carbon\Carbon::createFromFormat('Y-m-d', "2020-01-01") : \Carbon\Carbon::createFromFormat('Y-m-d', "{$q['start']}");
            $end = empty($q['end']) ? today() : \Carbon\Carbon::createFromFormat('Y-m-d', "{$q['end']}");

            $query = $missionRepository->new()->newQuery()->whereNotIn('phase', [MissionPhaseType::CANCEL->value]);
            $query = $query->whereBetween('started_at', [$start, $end])->latest('started_at');
            $query->chunk(100, function ($missions)
            {
                foreach ($missions as $mission)
                {
                    $map = $mission->data['map'];

                    $this->statisticMap[$map] = array_key_exists($map, $this->statisticMap) ? $this->statisticMap[$map] + 1 : 1;

                    $this->statisticMapValues[] = [
                        'id' => $mission->id,
                        'title' => $mission->title,
                        'map' => $map
                    ];
                }
            });

            return $this->jsonResponse('200', 'success', [
                'statistic' => [
                    'keys' => array_keys($this->statisticMap),
                    'values' => array_values($this->statisticMap)
                ],
                'data' => [
                    'total' => $query->count(),
                    'map_types' => array_keys(MissionMapType::getKoreanNames()),
                    'values' => $this->statisticMapValues
                ]
            ]);

        }
        catch (Exception $e)
        {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), config('app.debug') ? $e->getTrace() : []);
        }
    }
}
