<x-sub-page website-name="MGM Lounge" title="메인">
    <x-section.basic parent-class="py-4 sm:py-6" class="flex justify-center items-center">
        <div class="w-full md:w-2/3">
            <div class="py-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center my-4 lg:mt-0 lg:mb-6">가입 신청이 접수되었습니다.</h1>
                <div class="text-center">
                    <p>가입 심사는 멀티플레이 게임 매니지먼트 스탭이 직접 처리하고 있습니다. 가입 완료까지 다소 시간이 걸릴 수 있는 점 양해 부탁드립니다.</p>
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
