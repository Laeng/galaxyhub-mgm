<?php

namespace App\Http\Controllers\App\Mission;

use App\Enums\MissionPhaseType;
use App\Http\Controllers\Controller;
use App\Repositories\Mission\Interfaces\MissionRepositoryInterface;
use App\Repositories\Survey\Interfaces\SurveyEntryRepositoryInterface;
use App\Repositories\Survey\Interfaces\SurveyRepositoryInterface;
use App\Repositories\User\UserMissionRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendController extends Controller
{
    private MissionRepositoryInterface $missionRepository;
    private UserMissionRepository $userMissionRepository;
    private SurveyRepositoryInterface $surveyRepository;
    private SurveyEntryRepositoryInterface $surveyEntryRepository;

    public function __construct
    (
        MissionRepositoryInterface $missionRepository, UserMissionRepository $userMissionRepository,
        SurveyRepositoryInterface $surveyRepository, SurveyEntryRepositoryInterface $surveyEntryRepository,
    )
    {
        $this->missionRepository = $missionRepository;
        $this->userMissionRepository = $userMissionRepository;
        $this->surveyRepository = $surveyRepository;
        $this->surveyEntryRepository = $surveyEntryRepository;

    }

    public function attend(Request $request, int $missionId): Factory|View|Application|RedirectResponse
    {
        $user = Auth::user();
        $mission = $this->missionRepository->findById($missionId);

        if (is_null($mission))
        {
            abort(404);
        }

        if ($mission->user_id === $user->id)
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
        $hasSurvey = !is_null($mission->survey_id);

        if (!$canAttend && !$isFailAttend) {
            return redirect()->route('mission.read', $mission->id)->withErrors([
                'error' => '출석 기간이 아닙니다.'
            ]);
        }

        if ($isFailAttend) {
            return redirect()->route('mission.read', $mission->id)->withErrors([
                'error' => '출석 시도 횟수 초과로 출석 할 수 없습니다.'
            ]);
        }

        if ($hasAttend) {
            return redirect()->route('mission.read', $mission->id)->withErrors([
                'error' => '이미 출석 하셨습니다.'
            ]);
        }

        if ($request->isMethod('GET'))
        {
            if ($hasSurvey)
            {
                $survey = $this->surveyRepository->findById($mission->survey_id);
                $userSurvey = $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $survey->id);

                if ($userSurvey->count() <= 0)
                {
                    abort(404);
                }
            }
        }
        else
        {
            if (!$hasSurvey)
            {
                abort(405);
            }

            $survey = $this->surveyRepository->findById($mission->survey_id);
            $userSurvey = $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $survey->id);

            if ($userSurvey->count() <= 0)
            {
                $answers = $this->validate($request, $survey->validateRules());
                $this->surveyEntryRepository->new()->for($survey)->by($user)->fromArray($answers)->push();
            }

        }

        return view('app.mission.attend', [
            'mission' => $mission
        ]);
    }

    public function try(Request $request, int $missionId): JsonResponse
    {
        try
        {
            $this->jsonValidator($request, [
                'code' => 'string|required',
            ]);

            $mission = $this->missionRepository->findById($missionId);

            if (is_null($mission)) {
                throw new Exception('CAN NOT FOUND MISSION', 422);
            }

            if ($mission->phase !== MissionPhaseType::IN_ATTENDANCE->value) {
                throw new Exception('ATTEND TIME EXPIRES', 422);
            }

            $user = Auth::user();
            $code = trim($request->get('code'));

            $userMission = $this->userMissionRepository->findByUserIdAndMissionId($user->id, $mission->id);

            if (is_null($userMission))
            {
                throw new Exception('NOT PARTICIPATE MISSION', 422);
            }

            if (!is_null($mission->survey_id))
            {
                $survey = $this->surveyRepository->findById($mission->survey_id);
                $userSurvey = $this->surveyEntryRepository->findByUserIdAndSurveyId($user->id, $survey->id);

                if ($userSurvey->count() <= 0)
                {
                    throw new Exception('NOT PARTICIPATE SURVEY', 422);
                }
            }

            if (!is_null($userMission->attended_at)) {
                throw new Exception('ALREADY IN ATTENDANCE', 422);
            }

            if ($userMission->try_attends >= $this->userMissionRepository::MAX_ATTENDANCE_ATTEMPTS) {
                throw new Exception('ATTEMPTS EXCEEDED', 422);
            }

            $result = false;

            if ($mission->code === $code) {
                $result = true;
                $userMission->attended_at = now();
            }

            $userMission->try_attends += 1;
            $userMission->save();

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => $result,
                'count' => $userMission->try_attends,
                'limit' => $this->userMissionRepository::MAX_ATTENDANCE_ATTEMPTS
            ]);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), \Str::upper($e->getMessage()), config('app.debug')? $e->getTrace() : []);
        }
    }
}
