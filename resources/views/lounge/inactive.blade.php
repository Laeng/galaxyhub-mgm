<x-sub-page website-name="MGM Lounge" title="메인">
    <x-section.basic parent-class="py-4 sm:py-6" class="flex justify-center items-center">
        <div class="w-full md:w-2/3">
            <div class="py-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center my-4 lg:mt-0 lg:mb-6">휴면 계정 안내</h1>
                <div class="text-center">
                    <p>현재 회원님의 계정은 휴면 상태 입니다. 휴면 해제는 멀티플레이 게임 매니지번트 네이버 카페에서 권한 복구 신청을 통해 해제하실 수 있습니다.</p>
                </div>
                <div class="flex justify-center pt-6 pb-4 lg:pb-0 space-x-2">
                    <x-button.filled.md-blue type="button" onclick="location.href='{{ route('account.auth.logout') }}'">
                        로그아웃
                    </x-button.filled.md-blue>
                </div>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
