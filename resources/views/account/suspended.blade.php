<x-sub-page website-name="MGM Lounge" title="계정 정지됨">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16 lg:px-56" class="flex justify-center lg:px-48">
        <div class="w-full">
            <div class="flex justify-center lg:justify-start pt-16 lg:pt-48">
                <div class="space-y-8">
                    <div>
                        <h3 class="text-2xl lg:text-6xl font-bold lg:font-extrabold -mt-2 lg:mt-0">계정이 정지되었습니다.</h3>
                        <p class="lg:mt-4">
                            회원님의 계정이 @if($isPermanent)무기한@else일시@endif 정지 되었음을 알려드립니다.<br/>
                            계정 정지에 관하여 궁금하신 사항이 있다면 <a href="https://cafe.naver.com/gamemmakers" class="link-indigo" target="_blank">커뮤니티</a>에 남겨주시면 확인 후 연락드리겠습니다.<br/>
                        </p>
                    </div>

                    @if($comment !== '')
                        <div>
                            <p class="font-bold">정지 사유</p>
                            <p>{!! $comment !!}</p>
                        </div>
                    @endif
                    @if(!$isPermanent)
                        <div>
                            <p class="font-bold">정지 기간</p>
                            <p>{!! "{$ban->created_at->format('Y-m-d H:i')} ~ {$ban->expired_at->format('Y-m-d H:i')}" !!}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
