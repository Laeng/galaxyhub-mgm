<?php

namespace App\Http\Controllers\Software;

use App\Http\Controllers\Controller;
use App\Models\Software;
use App\Models\UserSoftware;
use Exception;
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

            if (is_null($userSoftware)) {
                $userSoftware = UserSoftware::create([
                    'software_id' => $software->id,
                    'software_version' => $version,
                    'ip' => $ip,
                    'machine_name' => $machineName,
                    'machine_version' => $machineVersion,
                    'code' => Str::uuid()
                ]);

                $result = false;

            } elseif (is_null($userSoftware->user_id)) {
                $result = false;
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

            $userSoftware = UserSoftware::where('ip', $request->getClientIp())->where('code', $request->get('code'))->latest()->first();

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            if (is_null($userSoftware->data)) {
                throw new Exception('DATA IS NULL', 200);
            }

            return $this->jsonResponse(200, 'SUCCESS', [
                'result' => true,
                'data' => $userSoftware->data
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

            $userSoftware = UserSoftware::where('ip', $request->getClientIp())->where('code', $request->get('code'))->latest()->first();

            if (is_null($userSoftware)) {
                throw new Exception('CAN NOT FOUND DATA', 200);
            }

            $userSoftware->data = $request->get('data');
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
}
