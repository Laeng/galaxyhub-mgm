<?php

namespace App\Http\Controllers\App\File;

use App\Http\Controllers\Controller;
use App\Services\File\Contracts\FileServiceContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CkeditorController extends Controller
{
    public FileServiceContract $fileService;

    public function __construct(FileServiceContract $fileService)
    {
        $this->fileService = $fileService;
    }

    public function create(Request $request, string $directory)
    {
        try
        {
            $this->jsonValidator($request, [
                'upload' => ["required", "image", "max:10240"],
            ]);

            if (!in_array($directory, ['mission']))
            {
                throw new Exception('Validation failed', 422);
            }

            $user = Auth::user();

            $uuid = Str::uuid();
            $path = sprintf("/%s/%s/%s/%s", config('filesystems.disks.do.folder'), $directory, substr($uuid, 0, 2), substr($uuid, 2, 2));

            $file = $this->fileService->create($request->file('upload'), 'do', $path, $uuid, $user->id, true);

            return response()->json(['status' => 200, 'description' => 'SUCCESS', 'url' => $this->fileService->getUrl($file->id)], 200);

        }
        catch (\Exception $e) {
            if (!array_key_exists($e->getCode(), Response::$statusTexts))
            {
                $status = 500;
            }

            return response()->json(['status' => $status, 'description' => $e->getMessage(), 'error' => ['message' => $e->getMessage()]], ($status == 0) ? 500 : $status);
        }
    }

    public function delete(Request $request)
    {
        try
        {
            $this->jsonValidator($request, [
                'id' => ["required", "int"]
            ]);

            $user = Auth::user();
            $file = $this->fileService->delete($request->get('id'), $user->id);

            return $this->jsonResponse(200, 'SUCCESS', ['result' => $file]);
        }
        catch (Exception $e)
        {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }
}
