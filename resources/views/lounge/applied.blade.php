<x-sub-page website-name="MGM Lounge" title="메인">
    <x-section.basic parent-class="py-4 sm:py-6" class="flex justify-center items-center">
        <div class="w-full md:w-2/3">
            <div class="py-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center my-4 lg:mt-0 lg:mb-6">가입 심사 안내</h1>
                <div class="text-center">
                    <p>현재 가입 신청이 접수되었습니다. <a href="https://cafe.naver.com/gamemmakers/book5076085/23131" target="_blank">MGM 아르마 클랜 가이드</a>를 확인하시어 놓치신 부분이 있는지 다시 한번 확인하여 주십시오.</p>
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
