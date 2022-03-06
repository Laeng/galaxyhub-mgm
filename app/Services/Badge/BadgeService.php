<?php

namespace App\Services\Badge;

use App\Repositories\Badge\Interfaces\BadgeRepositoryInterface;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Services\Badge\Contracts\BadgeServiceContract;
use Illuminate\Database\Eloquent\Collection;

class BadgeService implements BadgeServiceContract
{
    private BadgeRepositoryInterface $badgeRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(BadgeRepositoryInterface $badgeRepository, UserRepositoryInterface $userRepository)
    {
        $this->badgeRepository = $badgeRepository;
        $this->userRepository = $userRepository;
    }

    public function award(string $badgeName, int $userId): bool
    {
        $badge = $this->badgeRepository->findByName($badgeName);
        $user = $this->userRepository->findById($userId);

        if (!is_null($badge) && !is_null($user))
        {
            $badge->users()->attach($user->id);

            return true;
        }

        return false;
    }

    public function take(string $badgeName, int $userId): bool
    {
        $badge = $this->badgeRepository->findByName($badgeName);
        $user = $this->userRepository->findById($userId);

        if (!is_null($badge) && !is_null($user))
        {
            $badge->users()->attach($user->id);

            return true;
        }

        return false;
    }
}
