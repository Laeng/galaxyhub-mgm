<x-theme.galaxyhub.sub-center website-name="MGM Lounge" align-content="start">
    <div class="grid grid-cols-1 w-full gap-8 lg:px-48 py-6 lg:py-48">
        <div>
            <h1 class="mb-4 text-xl lg:text-3xl font-bold">
                계정이 비활성 되었습니다.
            </h1>
            <div>
                계정이 @if($isPermanent)무기한@else일시@endif 비활성 되었음을 알려드립니다.<br/>
                계정 비활성에 관하여 궁금하신 사항이 있다면 <a href="https://cafe.naver.com/gamemmakers" class="link-indigo" target="_blank">커뮤니티</a>에 남겨주시면 확인 후 연락드리겠습니다.
            </div>
        </div>
        @if($comment !== '')
            <div>
                <p class="font-bold">비활성 사유</p>
                <p>{!! $comment !!}</p>
            </div>
        @endif
        @if(!$isPermanent)
            <div>
                <p class="font-bold">비활성 기간</p>
                <p>{!! "{$ban->created_at->format('Y-m-d H:i')} ~ {$ban->expired_at->format('Y-m-d H:i')}" !!}</p>
            </div>
        @endif
    </div>


</x-theme.galaxyhub.sub-center>
