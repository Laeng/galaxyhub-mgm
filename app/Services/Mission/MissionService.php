<?php

namespace App\Services\Mission;

use App\Repositories\Mission\MissionRepository;
use App\Repositories\User\UserMissionRepository;
use App\Services\Mission\Contracts\MissionServiceContract;

class MissionService implements MissionServiceContract
{
    private MissionRepository $missionRepository;
    private UserMissionRepository $userMissionRepository;

    public function __construct(MissionRepository $missionRepository, UserMissionRepository $userMissionRepository)
    {
        $this->missionRepository = $missionRepository;
        $this->userMissionRepository = $userMissionRepository;
    }

    public function addParticipant(int $missionId, int $userId, bool $isMaker = false): bool
    {
        $mission = $this->missionRepository->findById($missionId);

        if (!is_null($mission)) {
            $hasParticipant = !is_null($this->userMissionRepository->findByUserIdAndMissionId($userId, $mission->id));

            if (!$hasParticipant) {
                $this->userMissionRepository->create([
                    'user_id' => $userId,
                    'mission_id' => $mission->id,
                    'is_maker' => $isMaker
                ]);

                return true;
            }
        }

        return false;
    }

    public function removeParticipant(int $missionId, int $userId): bool
    {
        $mission = $this->missionRepository->findById($missionId);

        if (!is_null($mission)) {
            $participant = $this->userMissionRepository->findByUserIdAndMissionId($userId, $mission->id);

            if (!is_null($participant)) {
                $this->userMissionRepository->delete($participant->id);

                return true;
            }
        }

        return false;
    }
}
