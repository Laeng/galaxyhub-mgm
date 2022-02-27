<x-theme.galaxyhub.sub-basics title="MGM 업데이터" description="MGM 업데이터">
    <section class="hidden lg:flex flex-col lg:flex-row py-4 lg:py-8 lg:space-x-16 items-center">
        <div class="lg:basis-3/5 px-8 pt-6 pb-4 lg:px-0 lg:py-8">
            <div class="">
                <img class="" src="{{ asset('images/mgm_updater.png') }}"/>
            </div>
        </div>

        <div class="lg:basis-2/5 pt-8 pb-4 lg:py-8 grid grid-cols-1 gap-4">
            <div>
                <h1 class="text-2xl lg:text-4xl font-black">MGM 업데이터</h1>
            </div>

            <div class="">
                <p class="font-bold">MGM 아르마 클랜 회원분들을 위한 특별한 프로그램</p>
                <p class="text-sm">Steam Workshop 구독 대신 MGM 업데이터로 편리하게 준비하세요.</p>
            </div>

            <div>
                <p class="text-sm">
                    MGM 업데이터는 수백개의 애드온 파일들을 간편하게 다운로드 받으실 수 있도록 제작되었습니다. 저장 장치의 남은 공간에 따라 필요한 애드온만 다운로드 받거나 무결성 검사를 통해 손상된 애드온을 복구할 수 있습니다.
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 dark:text-gray-300">
                    MGM 업데이터는 멀티플레이 게임 매니지먼트의 독점 프로그램이며 프로그램에 대한 사용권은 MGM 아르마 클랜 회원과 멀티플레이 게임 매니지먼트가 인가한 외부인에게만 제공됩니다.
                    본 프로그램에 대한 모든 권리는 멀티플레이 게임 매니지먼트와 윤창욱에게 있습니다. 본 프로그램을 사용하시면 개인정보처리방침에 기재된 서비스 제공을 위한 선택항목 수집에 동의하신 것으로 간주됨을 알려드립니다.
                </p>
            </div>

            <div class="pt-2 flex space-x-2 hidden lg:block">
                <x-button.filled.xl-blue>
                    다운로드
                </x-button.filled.xl-blue>

                <x-button.filled.xl-white>
                    설치 방법
                </x-button.filled.xl-white>
            </div>
        </div>
    </section>
    <section>
        <h1 class="my-4 lg:hidden text-2xl font-bold">MGM 업데이터</h1>
        <div class="mt-4 lg:mt-6">
            <x-panel.galaxyhub.basics>

            </x-panel.galaxyhub.basics>
        </div>
    </section>

</x-theme.galaxyhub.sub-basics>
