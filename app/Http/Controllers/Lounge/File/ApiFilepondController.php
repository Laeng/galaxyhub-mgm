<?php

namespace App\Http\Controllers\Lounge\File;

use App\Http\Controllers\Controller;

use App\Models\File as FileModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Flysystem\Filesystem;
use Response;
use Storage;
use Str;

class ApiFilepondController extends ApiFileController
{
    public function filepond_upload(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'filepond' => ["required", "image", "max:10240"]
            ]);

            $uuid = Str::uuid();
            $path = sprintf("/%s/%s/%s/%s", config('filesystems.disks.do.folder'), 'survey', substr($uuid, 0, 2), substr($uuid, 2, 2));

            $file = $this->upload($request, 'do', $path, $uuid, 'filepond');

            // 문제 있어요.
            // 1. 업로드한 이미지를 퍼블릭하게 볼 수 없음.
            // 2. S3 에 올라온 이미지 지우는 기능 구현 안함.
            // 3. 업로드 된 이미지에 대한 링크는 해당 설문의 값에 추가 되어 DB에 이미지 링크가 텍스트로 저장된다.

            // 아이디어
            // 가입 전 문답은 survey 기능 사용해서, 즉석에서 퀴즈가 생성되도록 form 을 만든다.
            // validation 필터에 정답을 삽입해서 $error 변수를 통해 정답을 보여줄 수 있도록 한다?. 한번 방법 찾아보세요. 정답이 설문 결과에 정답이 나와야 함.
            // 개인정보수집동의 -> 퀴즈 5문제 -> 합격, 탈락 표기 및 정답 표기 -> 가입 신청서 작성 -> 대기 방식으로 변경

            return $this->jsonResponse(200, 'SUCCESS', ['id' => $file->id]);

        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }

    public function filepond_delete(Request $request): JsonResponse
    {
        try {
            $this->jsonValidator($request, [
                'id' => ["required", "int"]
            ]);

            $file = $this->delete($request);

            return $this->jsonResponse(200, 'SUCCESS', ['result' => $file]);
        } catch (Exception $e) {
            return $this->jsonResponse($e->getCode(), Str::upper($e->getMessage()), []);
        }
    }
}
