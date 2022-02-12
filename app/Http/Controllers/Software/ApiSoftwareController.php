<?php

namespace App\Http\Controllers\Software;

use App\Http\Controllers\Controller;
use App\Models\Software;
use App\Models\UserSoftware;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiSoftwareController extends Controller
{
    public function verify(Request $request): JsonResponse
    {
        // 사용 권한이 있다면, code 를 제공하고, 없다면 생성
        try {
            $this->jsonValidator($request, [
                'name' => ['string', 'required'],
                'version' => ['string', 'required'],
                'machine_name' => ['string', 'required'],
                'machine_version' => ['string', 'required']
            ]);

            $ip = $request->getClientIp();
            $name = $request->get('name');
            $version = $request->get('version');
            $machineName = $request->get('machine_name');
            $machineVersion = $request->get('machine_version');

            $software = Software::where('name', $name)->latest()->first();

            if (is_null($software)) {
                throw new Exception('SOFTWARE NOT FOUND', 200);
            }

            if ($software->version !== $version) {
                // throw new Exception('NEED SOFTWARE UPDATE', 200);
            }

            $userSoftware = $software->users()->where('ip', $ip)->where('machine_name', $machineName)->where('machine_version', $machineVersion)->latest()->first();
            $result = true;

            $uuid = Str::uuid();

            if (is_null($userSoftware)) {
                $userSoftware = UserSoftware::create([
                    'software_id' => $software->id,
                    'software_version' => $version,
                    'ip' => $ip,
                    'machine_name' => $machineName,
                    'machine_version' => $machineVersion,
                    'code' => $uuid
                ]);

                $result = false;

            }
            else {
                if (is_null($userSoftware->user_id)) {
                    $result = false;
                }

                $userSoftware->setAttribute('code', $uuid);
                $userSoftware->save();
            }


            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => $result,
                'code' => $userSoftware->code
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
                'code' => ""
            ]);
        }
    }

    public function getUserData(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $userSoftware = $this->query($request->getClientIp(), $request->get('code'));

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $data = $userSoftware->getAttributeValue('data');

            if (is_null($data) || count($data) <= 0) {
                throw new Exception('DATA IS NULL', 200);
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => true,
                'data' => $data
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
                'data' => null
            ]);
        }
    }

    public function setUserData(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required'],
                'data' => ['required']
            ]);

            $userSoftware = $this->query($request->getClientIp(), $request->get('code'));

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $userSoftware->setAttribute('data', $request->get('data'));
            $userSoftware->save();

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => true,
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
            ]);
        }
    }

    public function ping(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'code' => ['uuid', 'required']
            ]);

            $userSoftware = $this->query($request->getClientIp(), $request->get('code'), false);

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $userSoftware->setUpdatedAt(now());
            $userSoftware->save();

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => true,
                'data' => null
            ]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), [
                'result' => false,
                'data' => null
            ]);
        }
    }

    private function query(string $ip, string $code, bool $checkDate = true): ?UserSoftware
    {
        $query = UserSoftware::where('ip', $ip)->where('code', $code);

        if ($checkDate)
        {
            $query->where('updated_at', '>=', now()->subHours(2));
        }

        return $query->latest()->first();
    }
}
