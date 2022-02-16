<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Services\File\Contracts\FileServiceContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FilepondController extends Controller
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
                'filepond' => ['required', 'image', 'max:10240'],
                'visible' => ['boolean']
            ]);

            if(!in_array($directory, ['survey']))
            {
                throw new Exception('Validation failed', 422);
            }

            $user = Auth::user();

            $uuid = Str::uuid();
            $path = sprintf("/%s/%s/%s/%s", config('filesystems.disks.do.folder'), $directory, substr($uuid, 0, 2), substr($uuid, 2, 2));

            $fileModel = $this->fileService->create($request->file('filepond'), 'do', $path, $uuid, $user->id, $request->get('visible', false));

            return $this->jsonResponse(200, 'SUCCESS', ['id' => $fileModel->id]);
        }
        catch(Exception $e)
        {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function delete(Request $request, string $directory)
    {
        try
        {
            $this->jsonValidator($request, [
                'id' => ["required", "int"]
            ]);

            if(!in_array($directory, ['survey']))
            {
                throw new Exception('Validation failed', 422);
            }

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
