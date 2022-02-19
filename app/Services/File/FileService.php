<?php

namespace App\Services\File;

use App\Models\File;
use App\Repositories\File\Interfaces\FileRepositoryInterface;
use App\Services\File\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class FileService
 * @package App\Services
 */
class FileService implements FileServiceContract
{
    public FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function create(UploadedFile|string $file, string $storage, string $path, string $name, ?int $userId = null, bool $visible = false): File
    {
        $fileModel = $this->fileRepository->create([
            'user_id' => $userId,
            'storage' => $storage,
            'path' => $path,
            'filename' => $file->getClientOriginalName(),
            'extension' => $file->extension(),
            'name' => $name,
            'visible' => $visible
        ]);

        Storage::disk($storage)->putFileAs($path, $file, "{$fileModel->name}.{$fileModel->extension}", $visible ? ['visibility' => 'public'] : []);

        return $fileModel;
    }

    public function delete(int $id, int $userId = null): bool
    {
        $fileModel = $this->fileRepository->findById($id);

        if (!is_null($fileModel))
        {
            if ($fileModel->user_id === $userId)
            {
                Storage::disk($fileModel->storage)->delete("{$fileModel->path}/{$fileModel->uuid}.{$fileModel->extension}");
                $fileModel->delete();

                return true;
            }
        }

        return false;
    }
}
