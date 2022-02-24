<?php

namespace App\Http\Controllers\App\Mission;

use App\Enums\MissionPhaseType;
use App\Enums\MissionType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Repositories\User\UserMissionRepository;
use App\Services\Survey\Contracts\SurveyServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    private MissionRepositoryInterface $missionRepository;
    private SurveyRepositoryInterface $surveyRepository;
    private SurveyEntryRepositoryInterface $surveyEntryRepository;
    private SurveyServiceContract $surveyService;
    private UserMissionRepository $userMissionRepository;

    public function __construct
    (
        MissionRepositoryInterface $missionRepository, UserMissionRepository $userMissionRepository,
        SurveyRepositoryInterface $surveyRepository, SurveyEntryRepositoryInterface $surveyEntryRepository,
        SurveyServiceContract $surveyService
    )
    {
        $this->missionRepository = $missionRepository;
        $this->userMissionRepository = $userMissionRepository;
        $this->surveyRepository = $surveyRepository;
        $this->surveyEntryRepository = $surveyEntryRepository;
        $this->surveyService = $surveyService;
    }

    public function report()
    {


        return '';
    }

    public function survey(Request $request, int $missionId): Factory|View|Application|RedirectResponse
    {
        $user = Auth::user();
        $mission = $this->missionRepository->findById($missionId);

        if (is_null($mission))
        {
            abort(404);
        }

        $isMaker = $mission->user_id === $user->id;

        if ($isMaker)
        {
            abort(404);
        }

        $hasSurvey = !is_null($mission->survey_id);

        if (!$hasSurvey && in_array($mission->type, MissionType::needSurvey()))
        {
            abort(404);
        }

        $userMission = $this->userMissionRepository->findByUserIdAndMissionId($user->id, $mission->id);

        if (is_null($userMission))
        {
            abort(404);
        }

        $isFailAttend = $userMission->try_attends >= $this->userMissionRepository::MAX_ATTENDANCE_ATTEMPTS;
        $canAttend = !$isFailAttend && $mission->phase === MissionPhaseType::IN_ATTENDANCE->value;
        $hasAttend = !is_null($userMission->attended_at);

        if (!$canAttend && !$hasAttend && !$isFailAttend)
        {
            return redirect()->route('mission.read')->withErrors([
                'error' => '만족도 조사 기간이 아닙니다.'
            ]);
        }

        $survey = $this->surveyRepository->findById($mission->survey_id);
        $surveyEntries = $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $survey->id);

        $isParticipate = $surveyEntries->count() > 0;
        $participateDate = $isParticipate ? $surveyEntries->first()->created_at->format('Y년 m월 d일 H시 i분') : null;
        $answer = $isParticipate ? $surveyEntries->first()->id : null;

        return view('app.mission.survey', [
            'user' => $user,
            'mission' => $mission,
            'survey' => $survey,
            'answer' => $answer,
            'missionType' => MissionType::getKoreanNames()[$mission->type],
            'isFailAttend' => $isFailAttend,
            'isParticipate' => $isParticipate,
            'participateDate' => $participateDate,
            'canAttend' => $canAttend,
            'hasAttend' => $hasAttend
        ]);
    }
}
