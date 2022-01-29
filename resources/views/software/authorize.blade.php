<x-sub-page website-name="MGM Lounge" title="계정 인증">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16 lg:px-56" class="flex justify-center lg:px-48">
        <div class="w-full">
            <div class="flex justify-center lg:justify-start pt-16 lg:pt-48">
                <div class="space-y-8">
                    @if(!$status)
                    <div>
                        <h3 class="text-2xl lg:text-6xl font-bold lg:font-extrabold -mt-2 lg:mt-0">계정 인증 실패</h3>
                        <p class="lg:mt-4">
                            소프트웨어가 이미 등록되었거나 사용 권한이 없어 계정 인증에 실패하였습니다.<br/>
                            만약 문제가 계속되면 <a href="https://cafe.naver.com/gamemmakers" class="link-indigo">커뮤니티</a>로 문의하여 주십시오.
                        </p>
                    </div>

                    @else

                    <div>
                        <h3 class="text-2xl lg:text-6xl font-bold lg:font-extrabold -mt-2 lg:mt-0">계정 인증 완료</h3>
                        <p class="lg:mt-4">
                            <span class="font-bold">{{ $softwareName }}</span> 프로그램으로 돌아가 <span class="font-bold">다음</span> 버튼을 눌러주십시오.<br/>
                        </p>
                    </div>
                    <div  class="space-y-1">
                        <div class="flex space-x-2">
                            <p class="font-bold">이름</p>
                            <p>{{ $machineName }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <p class="font-bold">IP</p>
                            <p>{{ $machineIp }}</p>
                        </div>
                    </div>

                    @endif
                </div>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
