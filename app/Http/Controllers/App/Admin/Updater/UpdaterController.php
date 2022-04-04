<?php

namespace App\Http\Controllers\App\Admin\Updater;

use App\Http\Controllers\Controller;
use App\Repositories\Updater\Interfaces\UpdaterRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UpdaterController extends Controller
{
    private array $dataValues = [];

    public function users(): View
    {
        return view('app.admin.updater.users');
    }

    public function data(Request $request, UpdaterRepositoryInterface $updaterRepository): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'query' => ['array']
            ]);

            $q = $request->get('query', []);
            $start = empty($q['start']) ? \Carbon\Carbon::createFromFormat('Y-m-d', "2020-01-01") : \Carbon\Carbon::createFromFormat('Y-m-d', "{$q['start']}");
            $end = empty($q['end']) ? today() : \Carbon\Carbon::createFromFormat('Y-m-d', "{$q['end']}");

            $query = $updaterRepository->new()->newQuery()->whereNotNull('user_id')->whereBetween('updated_at', [$start, $end]);
            $query = $query->with('user')->latest('updated_at');

            $query->chunk(100, function ($updaters)
            {
                foreach ($updaters as $updater)
                {
                    $codes = explode('-', $updater->code);
                    $versions = explode('.', $updater->version);

                    $chuck = [
                        'name' => $updater->machine_name,
                        'code' => "{$codes[1]}-{$codes[2]}-{$codes[3]}",
                        'ip' => $updater->ip,
                        'version' => "v{$versions[0]}.{$versions[1]}.{$versions[2]}",
                        'updated_at' => $updater->updated_at->format('Y-m-d H:i:s'),
                        'is_online' => !$updater->updated_at->addMinutes(1)->isPast()
                    ];

                    if (!is_null($updater->user))
                    {
                        $chuck += [
                            'user_id' => $updater->user->id,
                            'user_name' => $updater->user->name,
                        ];
                    }

                    $this->dataValues[] = $chuck;
                }
            });

            return $this->jsonResponse(200, 'SUCCESS', [
                'total' => count($this->dataValues),
                'data' => $this->dataValues,
            ]);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), config('app.debug') ? $e->getTrace() : []);
        }
    }
}
