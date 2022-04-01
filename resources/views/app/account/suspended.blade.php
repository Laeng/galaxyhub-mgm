<x-theme.galaxyhub.sub-center website-name="MGM Lounge" align-content="start">
    <div class="grid grid-cols-1 w-full gap-8 lg:px-48 py-6 lg:py-48">
        @if($comment === \App\Enums\BanCommentType::USER_PAUSE->value)
            <div>
                <h1 class="mb-4 text-xl lg:text-3xl font-bold">
                    장기 미접속 신청을 하셨습니다.
                </h1>
                <p>
                    회원님의 계정이 비활성 되었으며 장기 미접속 해제를 하시면 정상적으로 사용하실 수 있습니다.<br/>
                    장기 미접속 해제는 <a class="link-indigo" href="{{ route('account.pause') }}">회원 페이지</a>에서 하실 수 있습니다.
                </p>
            </div>
        @elseif($comment === \App\Enums\BanCommentType::APPLICATION_QUIZ_FAIL->value)
            <div>
                <h1 class="mb-4 text-xl lg:text-3xl font-bold">
                    가입 퀴즈 불합격 안내
                </h1>
                <p>
                    가입 퀴즈 불합격 하셨습니다. 일주일 후 다시 도전하실 수 있습니다.<br/>
                    궁금하신 사항이 있다면 <a href="https://cafe.naver.com/gamemmakers" class="link-indigo" target="_blank">커뮤니티</a>에 남겨주시면 확인 후 연락드리겠습니다.
                </p>
            </div>
        @else
            <div>
                <h1 class="mb-4 text-xl lg:text-3xl font-bold">
                    계정이 비활성 되었습니다.
                </h1>
                <p>
                    계정이 @if($isPermanent)무기한@else일시@endif 비활성 되었음을 알려드립니다.<br/>
                    계정 비활성에 관하여 궁금하신 사항이 있다면 <a href="https://cafe.naver.com/gamemmakers" class="link-indigo" target="_blank">커뮤니티</a>에 남겨주시면 확인 후 연락드리겠습니다.
                </p>
            </div>
            @if($comment !== '')
                <div>
                    <p class="font-bold">비활성 사유</p>
                    <p>{!! array_key_exists($comment, \App\Enums\BanCommentType::getKoreanNames()) ? \App\Enums\BanCommentType::getKoreanNames()[$comment] : $comment !!}</p>
                </div>
            @endif
            @if(!$isPermanent)
                <div>
                    <p class="font-bold">비활성 기간</p>
                    <p>{!! "{$ban->created_at->format('Y-m-d H:i')} ~ {$ban->expired_at->format('Y-m-d H:i')}" !!}</p>
                </div>
            @endif
        @endif
    </div>
</x-theme.galaxyhub.sub-center>
