<x-theme.galaxyhub.main website-name="멀티플레이 게임 매니지먼트" class="bg-gray-100">

    <div class="bg-cover bg-center relative -mt-[3.75rem]" style="background-image: url('{{ asset('images/background/welcome.jpg') }}')">
        <div class="bg-black/50">
            <x-container.galaxyhub.basics class="h-screen flex justify-center items-center">
                <div class="grid grid-cols-1 place-items-center">
                    <img class="w-16 lg:w-36 pb-4" alt="logo" src="https://mgmupdater.com/images/mgm.png"/>
                    <h1 class="text-3xl lg:text-5xl font-bold text-white mb-2 text-[#969B74]">멀티플레이 게임 매니지먼트</h1>
                    <p class="text-xl lg:text-2xl text-white/50 tracking-wider">Multiplay Game Management</p>
                </div>
            </x-container.galaxyhub.basics>
        </div>

        <div class="absolute w-full" style="bottom: 2rem; margin: 0; left: 0; right: 0;">
            <div class="flex flex-col justify-center text-center space-y-2">
                <svg class="h-8 w-auto"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 247 390">
                    <g>
                        <path style="fill:none;stroke:#fff;stroke-width:1rem;" d="M236.717,123.359c0,-62.565 -50.794,-113.359 -113.358,-113.359c-62.565,0 -113.359,50.794 -113.359,113.359l0,143.237c0,62.565 50.794,113.359 113.359,113.359c62.564,0 113.358,-50.794 113.358,-113.359l0,-143.237Z"></path>
                        <path id="wheel" style="fill:none;stroke:#fff;stroke-width:1rem;" d="M123.359,79.775l0,72.843"></path>
                    </g>
                </svg>
                <p class="block text-white opacity-80 text-sm uppercase text-center">SCROLL DOWN</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 dark:bg-gray-900">
        <x-container.galaxyhub.basics class="py-8 lg:py-32">
            <div class="lg:flex items-center">
                <div class="basis-1/2 py-4 lg:py-0">
                    <h2 class="text-4xl font-bold">ARMA3 & STAR CITIZEN</h2>
                    <p>국내 최고의 게임 클랜을 운영하고 있습니다.</p>
                </div>
                <div class="basis-1/2 space-y-2 py-4 lg:py-0">
                    <p>모든 종류의 모든 게임을 사랑하는 여러분을 환영합니다. 멀티플레이 게임 매니지먼트는 게임을 좋아하는 분들을 위한 공간입니다. 현재 많은 회원 분들의 도움으로 아르마3 클랜과 스타 시티즌 함대를 운영하고 있으며 비공개 서버 개설을 통해 러스트, 아크 서바이벌 이볼브, 마인크래프트와 같은 다양한 멀티 플레이 게임을 함께 즐기고 있습니다.</p>
                    <p>게임을 좋아하시는 여러분을 위해 멀티플레이 게임 매니지먼트의 운영진은 여러분들을 보좌하며 성심껏 보조할 것입니다. 방문 해주신 모든 분께 진심으로 감사를 전합니다.</p>
                </div>
            </div>
        </x-container.galaxyhub.basics>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-xl">
        <x-container.galaxyhub.basics class="py-12 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 pb-8 lg:pb-16">
                <div class="lg:order-last">
                    <div class="flex justify-end">
                        <img class="object-cover object-center rounded-lg bg-gray-200 h-48 lg:h-[32rem] w-full lg:w-4/5" src="{{ asset('images/background/welcome_desc_01.jpg') }}" alt=""/>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <h3 class="font-bold text-3xl">MGM 아르마 클랜</h3>
                            <p>
                                MGM 아르마 클랜은 2013년 8월부터 지금까지 이어진 대한민국 최고의 아르마 클랜입니다. 자체 개발한 장비와 유명 모더들에 의해 제작된 애드온을 통해 실감나고 재밌는 미션에 참여할 수 있습니다.
                            </p>
                        </div>
                        <ul class="pl-4 list-inside list-disc">
                            <li>자유로운 컨셉을 추구</li>
                            <li>전술과 협동을 중심으로</li>
                            <li>신규 유저도 언제나 환영</li>
                            <li>평일 주말 모두 플레이 가능</li>
                        </ul>
                        <x-button.filled.xl-blue type="button" onclick="location.href='https://cafe.naver.com/gamemmakers/book5076085/23131'">
                            가입하기
                        </x-button.filled.xl-blue>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                <div class="">
                    <div class="flex justify-start">
                        <img class="object-cover object-center rounded-lg bg-gray-200 h-48 lg:h-[32rem] w-full lg:w-4/5" src="{{ asset('images/background/welcome_desc_02.jpg') }}" alt=""/>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <h3 class="font-bold text-3xl">MGM 스타 플릿</h3>
                            <p>
                                MGM 스타 플릿은 스타 시티즌 함대이며 공격적인 전투 함대의 성향보다는 방어적이고 중립적인 평화 지향성 커뮤니티에 더 가깝습니다. 이로 인하여 공격적인 플레이를 원하는 전투형 플레이어들은 지루하실 수도 있겠지만, MGM 스타 플릿의 항해를 겪어보신다면 항해 중 벌어지는 다양한 일들이 결국은 여러분들을 사로잡게 될 것 입니다.
                            </p>
                        </div>
                        <ul class="pl-4 list-inside list-disc">
                            <li>단합형 친목 함대</li>
                            <li>철저한 실력 주의</li>
                            <li>전술과 협동을 중심으로</li>
                            <li>신규 유저도 언제나 환영</li>
                        </ul>
                        <x-button.filled.xl-blue type="button" onclick="location.href='https://cafe.naver.com/gamemmakers/49102'">
                            가입하기
                        </x-button.filled.xl-blue>
                    </div>
                </div>
            </div>
        </x-container.galaxyhub.basics>
    </div>

    <div class="bg-gradient-to-r from-sky-500 to-indigo-500 shadow-inner shadow-black/20">
        <x-container.galaxyhub.basics class="py-16 lg:py-32 space-y-8">
            <div class="lg:py-0 space-y-2">
                <h2 class="text-4xl font-bold text-white">더 많은 재미를 위해</h2>
                <p class="text-gray-200">회원님들과 함께 더 즐거운 게임 플레이 환경이 될 수 있도록 노력하고 있습니다.</p>
            </div>

            <div class="lg:pt-8 grid grid-cols-3">
                <div>
                    <p class="font-black text-xl md:text-6xl text-white">5</p>
                    <p class="font-medium lg:text-xl text-white">SERVERS</p>
                </div>
                <div>
                    <p class="font-black text-xl md:text-6xl text-white">25</p>
                    <p class="font-medium lg:text-xl text-white">STAFFS</p>
                </div>
                <div>
                    <p class="font-black text-xl md:text-6xl text-white">4100+</p>
                    <p class="font-medium lg:text-xl text-white">MEMBERS</p>
                </div>
            </div>
        </x-container.galaxyhub.basics>
    </div>

    <div class="dark:bg-gray-800">
        <x-container.galaxyhub.basics class="py-16 lg:py-32 space-y-8">

            <dl class="grid grid-cols-1 md:grid-cols-3  gap-4">
                <div class="px-4 py-5 bg-white dark:bg-gray-900 shadow overflow-hidden sm:p-6 flex flex-col">
                    <dt class="text-2xl font-bold text-gray-900 dark:text-gray-100">MGM</dt>
                    <dd class="mt-1 mb-4 text-sm text-gray-500 dark:text-gray-300">멀티플레이 게임 매니지먼트의 중심입니다. 2008년 게임 플레이 영상 제작 및 공유 카페에서 아르마2 및 게리 모드 커뮤니티를 거쳐 국내 최대의 아르마3 클랜과 스타 시티즌 함대를 운영중인 커뮤니티로 거듭났습니다.</dd>
                    <x-button.filled.md-white class="w-full mt-auto" onclick="location.href='https://cafe.naver.com/gamemmakers'">
                        바로가기
                    </x-button.filled.md-white>
                </div>

                <div class="px-4 py-5 bg-white dark:bg-gray-900 shadow overflow-hidden sm:p-6 flex flex-col">
                    <dt class="text-2xl font-bold text-gray-900 dark:text-gray-100">Galaxyhub</dt>
                    <dd class="mt-1 mb-4 text-sm text-gray-500 dark:text-gray-300">크라우드 펀딩으로 제작되는 AAA 게임인 스타 시티즌의 개발 정보를 공유하고 함께 즐기는 공간입니다. 한국 스타 시티즌의 진흥과 언어 장벽 해소에 기여하고자 노력하고 있습니다.</dd>
                    <x-button.filled.md-white class="w-full mt-auto" onclick="location.href='https://galaxyhub.kr'">
                        바로가기
                    </x-button.filled.md-white>
                </div>

                <div class="px-4 py-5 bg-white dark:bg-gray-900 shadow overflow-hidden sm:p-6 flex flex-col">
                    <dt class="text-2xl font-bold text-gray-900 dark:text-gray-100">MGM Lounge</dt>
                    <dd class="mt-1 mb-4 text-sm text-gray-500 dark:text-gray-300">MGM 아르마 클랜 회원분들을 위한 미션 신청 및 출석 그리고 애드온을 간편하게 다운로드 받을 수 있도록 돕는 MGM 업데이터를 다운로드 받을 수 있습니다.</dd>
                    <x-button.filled.md-white class="w-full mt-auto" onclick="location.href='{{ route('app.index') }}'">
                        바로가기
                    </x-button.filled.md-white>
                </div>

                <div class="px-4 py-5 bg-white dark:bg-gray-900 shadow overflow-hidden sm:p-6 flex flex-col">
                    <dt class="text-2xl font-bold text-gray-900 dark:text-gray-100">스타 시티즌 유저 한국어 프로젝트</dt>
                    <dd class="mt-1 mb-4 text-sm text-gray-500 dark:text-gray-300">스타 시티즌의 언어 장벽을 허물고자 타 커뮤니티와 연합하여 번역 및 인프라를 지원하고 있습니다.</dd>
                    <x-button.filled.md-white class="w-full mt-auto" onclick="location.href='https://sc.galaxyhub.kr'">
                        바로가기
                    </x-button.filled.md-white>
                </div>

                <div class="px-4 py-5 bg-white dark:bg-gray-900 shadow overflow-hidden sm:p-6 flex flex-col">
                    <dt class="text-2xl font-bold text-gray-900 dark:text-gray-100">아르마3 사표 계산기</dt>
                    <dd class="mt-1 mb-4 text-sm text-gray-500 dark:text-gray-300">아르마3 장비들의 조준을 돕는 사표 계산기입니다.</dd>
                    <x-button.filled.md-white class="w-full mt-auto" onclick="location.href='https://calc.galaxyhub.kr'">
                        바로가기
                    </x-button.filled.md-white>
                </div>

                <div class="px-4 py-5 bg-white dark:bg-gray-900 shadow overflow-hidden sm:p-6 flex flex-col">
                    <dt class="text-2xl font-bold text-gray-900 dark:text-gray-100">아르마의 밤</dt>
                    <dd class="mt-1 mb-4 text-sm text-gray-500 dark:text-gray-300">민주주의를 수호하는 미군이 되거나 폭탄 테러를 저지하는 용병이 되는 등 다양한 미션들이 여러분들을 기다립니다. MGM 아르마 클랜에 가입하신다면 함께 하실 수 있습니다.</dd>
                    <div style="height: 2.357rem"></div>
                </div>

                <div class="px-4 py-5 bg-white dark:bg-gray-900 shadow overflow-hidden sm:p-6 flex flex-col">
                    <dt class="text-2xl font-bold text-gray-900 dark:text-gray-100">MGM 업데이터</dt>
                    <dd class="mt-1 mb-4 text-sm text-gray-500 dark:text-gray-300">번거로운 Steam Workshop 구독을 대신 간편하게 애드온을 다운로드 받을 수 있도록 돕는 프로그램입니다. MGM 아르마 클랜의 독점 애드온들을 쉽게 다운로드 받을 수 있습니다.</dd>
                    <div style="height: 2.357rem"></div>
                </div>

                <div class="px-4 py-5 bg-white dark:bg-gray-900 shadow overflow-hidden sm:p-6 flex flex-col">
                    <dt class="text-2xl font-bold text-gray-900 dark:text-gray-100">Teamspeak3</dt>
                    <dd class="mt-1 mb-4 text-sm text-gray-500 dark:text-gray-300">MGM 아르마 클랜 및 MGM 스타 플릿 함대 가입 회원님들을 대상으로 비공개 팀스피크 서버를 24시간 운영 중에 있습니다. </dd>
                    <div style="height: 2.357rem"></div>
                </div>

                <div class="px-4 py-5 bg-white dark:bg-gray-900 shadow overflow-hidden sm:p-6 flex flex-col">
                    <dt class="text-2xl font-bold text-gray-900 dark:text-gray-100">비공개 게임 서버</dt>
                    <dd class="mt-1 mb-4 text-sm text-gray-500 dark:text-gray-300">마인크래프트, 아크 서바이벌 이볼브, 러스트, 데이즈 등 비공개 게임 서버 개설이 가능한 멀티플레이 기반 게임들을 선정하여 비정규적으로 운영하고 있습니다.</dd>
                    <div style="height: 2.357rem"></div>
                </div>
            </dl>
        </x-container.galaxyhub.basics>
    </div>

    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 shadow-inner shadow-black/20">
        <x-container.galaxyhub.basics class="py-16 lg:py-32 space-y-8">
            <div class="space-y-2">
                <h2 class="text-4xl font-bold text-white">문의 & 제안</h2>
                <p class="text-gray-200">MGM 네이버카페에 남겨주시면 확인 후 연락드리겠습니다.</p>
            </div>
            <div class="mt-4">
                <x-button.filled.xl-white>
                    바로가기
                </x-button.filled.xl-white>
            </div>

        </x-container.galaxyhub.basics>
    </div>

</x-theme.galaxyhub.main>
