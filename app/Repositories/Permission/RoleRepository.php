<?php

namespace App\Repositories\Permission;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Permission\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public Role $model;

    #[Pure]
    public function __construct(Role $model)
    {
        parent::__construct($model);

        $this->model = $model;
    }

    public function findByUserId(string $userId, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->select($columns)->where('user_id', $userId)->with($relations)->latest()->first();
    }

    #[ArrayShape([
        '가입 신청' => "string",
        '가입 보류' => "string",
        '가입 거절' => "string",
        '멤버' => "string",
        '임시 메이커' => "string",
        '정식 메이커' => "string",
        '관리자' => "string"
    ])]
    public function getNames(): array
    {
        return [
            '가입 신청' => 'apply',
            '가입 보류' => 'defer',
            '가입 거절' => 'reject',
            '멤버' => 'member',
            '임시 메이커' => 'maker1',
            '정식 메이커' => 'maker2',
            '관리자' => 'staff'
        ];
    }
}
