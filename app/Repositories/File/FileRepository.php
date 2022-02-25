<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Repositories\Base\BaseRepository;
use App\Repositories\File\Interfaces\FileRepositoryInterface;
use JetBrains\PhpStorm\Pure;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    private File $model;

    #[Pure]
    public function __construct(File $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }
}
