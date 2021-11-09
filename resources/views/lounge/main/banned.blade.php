<x-sub-page website-name="MGM Lounge" title="메인">
    <x-section.basic parent-class="py-4 sm:py-6" class="flex justify-center items-center">
        <div class="w-full md:w-2/3">
            <div class="py-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center my-4 lg:mt-0 lg:mb-6">계정 정지 안내</h1>
                <div class="text-center">
                    <p>MGM Lounge 이용 약관에 의거하여 회원님의 계정이 정지되었습니다. 정지 사유 및 기타 문의는 멀티플레이 게임 매니지먼트 네이버 카페를 통해 문의해 주시기 바랍니다.</p>
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
