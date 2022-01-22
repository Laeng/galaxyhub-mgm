<?php

namespace App\Http\Controllers\Lounge\File;

use App\Http\Controllers\Controller;

use App\Models\File as FileModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ApiFileController extends Controller
{
    public function filepond_upload(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'filepond' => ["required", "image", "max:10240"]
            ]);

            $uuid = Str::uuid();
            $path = sprintf("/%s/%s/%s/%s", config('filesystems.disks.do.folder'), 'survey', substr($uuid, 0, 2), substr($uuid, 2, 2));

            $file = $this->upload($request, 'do', $path, $uuid, 'filepond');

            return $this->jsonResponse(200, 'SUCCESS', ['id' => $file->id]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function filepond_delete(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'id' => ["required", "int"]
            ]);

            $file = $this->delete($request);

            return $this->jsonResponse(200, 'SUCCESS', ['result' => $file]);
        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function ckeditor_upload(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'upload' => ["required", "image", "max:10240"]
            ]);

            $url = config('filesystems.disks.do.url');
            $uuid = Str::uuid();
            $path = sprintf("/%s/%s/%s/%s", config('filesystems.disks.do.folder'), 'mission', substr($uuid, 0, 2), substr($uuid, 2, 2));

            $file = $this->upload($request, 'do', $path, $uuid, 'upload');

            if (is_null($file)) {
                throw new Exception('NULL', 422);
            }

            return response()->json(['status' => 200, 'description' => 'SUCCESS', 'url' => "{$url}{$file->path}/{$file->uuid}.{$file->extension}"], 200);

        } catch (Exception $e) {
            if (!array_key_exists($e->getCode(), Response::$statusTexts)) {
                $status = 500;
            }

            return response()->json(['status' => $status, 'description' => $e->getMessage(), 'error' => ['message' => $e->getMessage()]], ($status == 0) ? 500 : $status);
        }
    }

    private function upload(Request $request, string $storage, string $path, string $uuid, string $attributeName = 'file'): FileModel
    {
        // 만약 CDN 까지 함께 처리하고 싶다면...
        // https://lightit.io/blog/using-digital-ocean-spaces-with-laravel-8/ 참고

        $user = $request->user();
        $input = $request->file($attributeName);

        $file = FileModel::create([
            'user_id' => (!is_null($user)) ? $user->id : null,
            'storage' => $storage,
            'path' => $path,
            'filename' => $input->getClientOriginalName(),
            'extension' => $input->extension(),
            'uuid' => $uuid
        ]);

        Storage::disk('do')->putFileAs($path, $input, "{$file->uuid}.{$file->extension}");
        return $file;
    }

    private function delete(Request $request): bool
    {
        $id = $request->get('id');
        $user = $request->user();

        if (!is_null($user)) {
            $file = $user->files()->find($id)->first();

            if (!is_null($file)) {
                Storage::disk($file->storage)->delete("{$file->path}/{$file->uuid}.{$file->extension}");
                $file->delete();

                return true;
            }
        }

        return false;
    }
}
