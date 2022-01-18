<?php

namespace App\Http\Controllers\Lounge\File;

use App\Http\Controllers\Controller;

use App\Models\File as FileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiFileController extends Controller
{
    protected function upload(Request $request, string $storage, string $path, string $uuid, string $attributeName = 'file'): FileModel
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

    protected function delete(Request $request): bool
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
