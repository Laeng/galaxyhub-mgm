<?php

namespace App\Services\File\Contracts;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

/**
 * Interface FileServiceContract
 * @package App\Services\Contracts
 */
interface FileServiceContract
{
    public function create(UploadedFile|string $file, string $storage, string $path, string $name, ?int $userId = null, bool $visible = false): File;

    public function delete(int $id, int $userId = null): bool;

    public function getUrl(int $fileId): string;

    public function getUrlToDirectly(string $storage, string $path, string $filename, bool $visible = true, ?Carbon $expire = null): string;
}
