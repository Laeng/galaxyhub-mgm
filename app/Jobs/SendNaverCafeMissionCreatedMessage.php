<?php

namespace App\Jobs;

use App\Enums\MissionType;
use App\Models\Mission;
use App\Services\Naver\Contracts\NaverServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNaverCafeMissionCreatedMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $cafeId;
    private int $menuId;
    private Mission $mission;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $cafeId, int $menuId, Mission $mission)
    {
        $this->cafeId = $cafeId;
        $this->menuId = $menuId;
        $this->mission = $mission;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NaverServiceContract $naverService)
    {
        $link = route('mission.read', $this->mission->id);

        $content = $this->mission->body;
        $content .= "<div class='CafeViewer'><div class='se-viewer' lang='ko-KR'><div class='se-section-text se-text se-l-default'>";
        $content .= "<p class='se-text-paragraph se-text-paragraph-align-'><span class='se-fs-fs11 se-ff-'>&nbsp;</span></p>";
        $content .= "<p class='se-text-paragraph se-text-paragraph-align-'><span class='se-fs se-ff'><a href='{$link}' class='se-link' target='_blank'><b>참가 신청하기</b></a></span></p>";
        $content .= "<p class='se-text-paragraph se-text-paragraph-align-'><span class='se-fs-fs11 se-ff-'>&nbsp;</span></p>";
        $content .= "<p class='se-text-paragraph se-text-paragraph-align-'><span class='se-fs-fs11 se-ff-'>본 게시글은 자동 작성된 게시글 입니다. 본 내용은 미션 메이커가 최초 등록시 작성한 미션 내용이며 실제 미션 내용과 다를 수 있습니다.</span></p>";
        $content .= "<p class='se-text-paragraph se-text-paragraph-align-'><span class='se-fs-fs11 se-ff-'>미션 참가 신청 전 등록된 미션 정보를 반드시 확인해 주시기 바랍니다.</span></p>";
        $content .= "<p class='se-text-paragraph se-text-paragraph-align-'><span class='se-fs-fs11 se-ff-'>미션 참가는 MGM 아르마3 클랜에 가입한 회원만 가능합니다.</span></p>";
        $content .= "</div></div></div>";

        $naverService->refreshToken();
        $naverService->writePost($this->cafeId, $this->menuId, $this->mission->title, $content);
    }
}
