<x-theme.galaxyhub.sub-center website-name="MGM Lounge" align-content="start">
    <div class="grid grid-cols-1 w-full gap-8 lg:px-48 py-6 lg:py-48">
        @if($status)
            <div>
                <h1 class="mb-4 text-xl lg:text-3xl font-bold">
                    인증 완료
                </h1>
                <p>
                    이제 <span class="font-bold">MGM 업데이터</span>에서 <span class="font-bold">다음</span> 버튼을 눌러주십시오.<br/>
                </p>
            </div>
            <div class="mt-8 space-y-1">
                <div class="flex space-x-2">
                    <p class="font-bold">PC</p>
                    <p>{{ $machineName }}</p>
                </div>
                <div class="flex space-x-2">
                    <p class="font-bold">IP</p>
                    <p>{{ $machineIp }}</p>
                </div>
            </div>
        @else
            <div>
                <h1 class="mb-4 text-xl lg:text-3xl font-bold">
                    계정 인증 실패
                </h1>
                <p>
                    인증 링크가 만료되었거나 사용 권한이 없어 계정 인증에 실패하였습니다.<br/>
                    만약 문제가 계속되면 <a href="https://cafe.naver.com/gamemmakers" class="link-indigo">커뮤니티</a>로 문의하여 주십시오.
                </p>
            </div>
        @endif
    </div>


</x-theme.galaxyhub.sub-center>
