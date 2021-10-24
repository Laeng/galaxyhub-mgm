<x-layout.layout title="멀티플레이 게임 매니지먼트">
    <style>
        :root {
            --banner-text-opacity: 1;
            --banner-text-translate-x: 0;
        }
        .bto {
            --tw-text-opacity: var(--banner-text-opacity, 1);
        }

        .bttr {
            --tw-translate-x: calc(var(--banner-text-translate-x, 0) * -1);
        }

        .bttl {
            --tw-translate-x: var(--banner-text-translate-x, 0);
        }

    </style>

    <x-layout.header parent-class="bg-gray-900 w-full ho" logo-hex-code="" logo-text-class="text-pink-600 hover:text-pink-500" menu-text-class="text-gray-200 lg:text-sm" website-name="멀티플레이 게임 매니지먼트"/>

    <section class="relative h-screen bg-gray-900">
        <div class="bg-cover bg-center bg-fixed h-full" style="background-image: url('https://cdn.discordapp.com/attachments/229099609140494336/883515414125088778/20210904093553_1.jpg')">
            <div class="h-full">
                <div class="max-w-7xl mx-auto py-4 px-4 h-full" style="">

                    <div class="grid grid-cols-1 place-items-center h-full relative -mt-10 md:-mt-8 xl:mt-0">
                        <div class="w-full w-4/5">
                            <svg class="block stroke-current stroke-1 text-3xl md:text-6xl xl:text-8xl font-black text-white w-full transform bto bttl">
                                <text class="uppercase w-full" style="fill: transparent" x="0" y="100" font-size="100%">No one</text>
                            </svg>
                            <svg class="block -mt-28 md:-mt-20 xl:-mt-14 stroke-current stroke-1 text-3xl md:text-6xl xl:text-8xl font-black text-white w-full transform bto bttr">
                                <text class="uppercase w-full" style="fill: transparent" x="0" y="100" font-size="100%">left behind</text>
                            </svg>
                            <p class="block -mt-10 md:-mt-8 text-white opacity-80 md:text-2xl xl:text-3xl transform bto">Multiplay Game Management</p>
                        </div>
                    </div>

                    <div class="absolute w-full" style="bottom: 2rem; margin: 0; left: 0; right: 0;">
                        <div class="flex flex-col justify-center text-center space-y-2">
                            <svg class="h-8 w-auto" style="opacity: var(--banner-text-opacity)"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 247 390">
                                <g>
                                    <path style="fill:none;stroke:#fff;stroke-width:1rem;" d="M236.717,123.359c0,-62.565 -50.794,-113.359 -113.358,-113.359c-62.565,0 -113.359,50.794 -113.359,113.359l0,143.237c0,62.565 50.794,113.359 113.359,113.359c62.564,0 113.358,-50.794 113.358,-113.359l0,-143.237Z"></path>
                                    <path id="wheel" style="fill:none;stroke:#fff;stroke-width:1rem;" d="M123.359,79.775l0,72.843"></path>
                                </g>
                            </svg>
                            <p class="block text-white opacity-80 text-sm uppercase text-center bto">SCROLL DOWN</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <x-section.base parent-class="bg-purple-800 text-white" class="py-16 lg:py-24">
        <div class="flex justify-center">
            <div class="w-full">
                <h3 class="text-xl lg:text-3xl font-medium mb-2">최고의 멀티플레이 게임 커뮤니티</h3>
                <p>2008년, 수많은 게임들을 함께 즐기고자 시작된 멀티플레이 게임 매니지먼트는 아르마 시리즈와 스타 시티즌을 중심으로한 다양한 게임들로 회원분들과 함께하고 있습니다.</p>
            </div>
        </div>
    </x-section.base>

    <x-section.base parent-class="bg-white" class="py-16 lg:py-32">
        <div class="grid grid-cols-1 text-center pb-16">
            <h1 class="font-bold text-4xl font-medium">Group</h1>
            <p class="text-gray-600">멀티플레이 게임 매니지먼트가 운영하는 게임 그룹</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 pb-8 lg:pb-16">
            <div class="lg:order-last">
                <div class="flex justify-end">
                    <img class="object-cover object-center rounded-lg bg-gray-200 h-48 lg:h-[32rem] w-full lg:w-4/5" src="https://cdn.discordapp.com/attachments/435715019888394240/887132576563724358/arma3_agls_asip_mod1.png" alt=""/>
                </div>
            </div>

            <div class="flex items-center">
                <div class="prose max-w-ful">
                    <h2>MGM 아르마 클랜</h2>
                    <p>
                        MGM 아르마 클랜은 2013년 8월부터 지금까지 이어진 대한민국 최고의 아르마 클랜입니다. 자체 개발한 장비와 유명 모더들에 의해 제작된 애드온을 통해 실감나고 재밌는 미션에 참여할 수 있습니다.
                    </p>
                    <ul class="list-inside">
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
                    <img class="object-cover object-center rounded-lg bg-gray-200 h-48 lg:h-[32rem] w-full lg:w-4/5" src="https://cdn.discordapp.com/attachments/229019174087688194/886552502235975710/ScreenShot-2021-09-12_18-17-48-726.jpg" alt=""/>
                </div>
            </div>

            <div class="flex items-center">
                <div class="prose max-w-ful">
                    <h2>MGM 스타 플릿</h2>
                    <p>
                        MGM 스타 플릿은 스타 시티즌 함대이며 공격적인 전투 함대의 성향보다는 방어적이고 중립적인 평화 지향성 커뮤니티에 더 가깝습니다. 이로 인하여 공격적인 플레이를 원하는 전투형 플레이어들은 지루하실 수도 있겠지만, MGM 스타 플릿의 항해를 겪어보신다면 항해 중 벌어지는 다양한 일들이 결국은 여러분들을 사로잡게 될 것 입니다.
                    </p>
                    <ul class="list-inside">
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

    </x-section.base>

    <x-section.base parent-class="bg-indigo-700 text-white" class="py-16 lg:py-24">
        <div class="flex justify-center">
            <div class="w-full text-right">
                <h3 class="text-xl lg:text-3xl font-medium mb-2">멀티플레이 게임 매니지먼트</h3>
                <p>갤럭시허브, 라운지와 같은 서비스와 업데이터를 통해 더 재밌는 게임 경험이 될 수 있도록 회원분들을 지원하고 있습니다.</p>
            </div>
        </div>
    </x-section.base>

    <x-section.base parent-class="bg-gray-100" class="py-16 lg:py-32">
        <div class="grid grid-cols-1 text-center pb-16">
            <h1 class="font-bold text-4xl font-medium">Community</h1>
            <p class="text-gray-600">멀티플레이 게임 매니지먼트가 운영하는 커뮤니티</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-10 gap-8">
            <div class="lg:col-span-4 rounded-lg bg-[#04CF5B] lg:h-[32rem] transform hover:-translate-y-2 hover:shadow-lg p-8 lg:p-16">
                <div class="flex flex-col max-w-full h-full">
                    <h2 class="text-2xl font-medium text-white mb-2 lg:mb-6">네이버 카페</h2>
                    <p class="flex-grow text-white">멀티플레이 게임 매니지먼트의 중심 커뮤니티입니다. 2008년 개설되었으며 MGM 아르마 클랜 소식을 접하실 수 있습니다.</p>
                    <x-button.filled.xl-white class="mt-6" type="button" onclick="location.href='https://cafe.naver.com/gamemmakers'">
                        바로가기
                    </x-button.filled.xl-white>
                </div>
            </div>

            <div class="lg:col-span-3 rounded-lg bg-purple-600 lg:h-[32rem] transform hover:-translate-y-2 hover:shadow-lg p-8 lg:p-16">
                <div class="flex flex-col max-w-full h-full">
                    <h2 class="text-2xl font-medium text-white mb-2 lg:mb-6">갤럭시허브</h2>
                    <p class="flex-grow text-white">크라우드 펀딩을 통해 개발 중인 스타 시티즌을 중심 주제로 다루는 커뮤니티 입니다. 또한 인프라 제공과 개발을 통해 멀티플레이 게임 매니지먼트 및 다양한 이벤트를 지원하고 있습니다.</p>
                    <x-button.filled.xl-white class="mt-6" type="button" onclick="location.href='https://galaxyhub.kr'">
                        바로가기
                    </x-button.filled.xl-white>
                </div>
            </div>

            <div class="lg:col-span-3 rounded-lg bg-indigo-600 lg:h-[32rem] transform hover:-translate-y-2 hover:shadow-lg p-8 lg:p-16">
                <div class="flex flex-col max-w-full h-full">
                    <h2 class="text-2xl font-medium text-white mb-2 lg:mb-6">라운지</h2>
                    <p class="flex-grow text-white">MGM 아르마 클랜원 분들의 플레이를 지원하고자 개설되었으며 미션 신청 시스템 및 애드온 업데이터를 제공하고 있습니다.</p>
                    <x-button.filled.xl-white class="mt-6" type="button" onclick="location.href='#'">
                        바로가기
                    </x-button.filled.xl-white>
                </div>
            </div>
        </div>

    </x-section.base>

    <x-section.base parent-class="bg-gray-200" class="py-16 lg:py-24">
        <div class="flex justify-center">
            <div class="w-full">
                <h3 class="text-2xl lg:text-3xl font-medium uppercase mb-2">No one left behind</h3>
                <p>멀티플레이 게임 매니지먼트의 모토입니다. 피해가 예상되는 전장 한가운데일지라도 아무도 버리고 떠나지 않습니다. 다함께 즐기고 서로 돕습니다.</p>
            </div>
        </div>
    </x-section.base>

    <x-section.base parent-class="bg-white" class="py-16 lg:py-32">
        <div class="grid grid-cols-1 text-center pb-16">
            <h1 class="font-bold text-4xl font-medium">Contact</h1>
            <p class="text-gray-600">멀티플레이 게임 매니지먼트의 연락처</p>
        </div>
        <div class="py-4 mb:py-8 px-4 bg-gray-100 rounded-lg">
            <div class="grid grid-cols-1">
                <h3 class="text-3xl text-center font-semibold pt-6">네이버 카페</h3>

                <div class="flex justify-center pt-4 md:px-6">
                    <div class="w-2/3">
                        <p class="lg:block text-center">
                            현재 모든 문의는 멀티플레이 게임 매니지먼트의 네이버 카페를 통해 받고 있습니다. 카페 가입 후 자유 게시판 또는 질문 답변 게시판에 연락처와 함께 남겨주시면 확인 후 연락드리겠습니다.
                        </p>
                    </div>
                </div>

                <div class="flex justify-center items-center pt-6 pb-6">
                    <x-button.filled.xl-blue type="button" onclick="location.href='https://cafe.naver.com/gamemmakers'">
                        바로가기
                    </x-button.filled.xl-blue>
                </div>
            </div>
        </div>
    </x-section.base>


    <script type="text/javascript">
        let d = document.documentElement;

        window.addEventListener('scroll', (e) => {
            let y = ((window.pageYOffset || d.scrollTop) - (d.clientTop || 0));
            d.style.setProperty('--header-opacity', calc(y, 100));
            d.style.setProperty('--header-text-filter',  calc(y, 0.1, 20));
            d.style.setProperty('--banner-text-opacity', 1 - calc(y, 500));
            d.style.setProperty('--banner-text-translate-x', 1 - calc(y, 10, 100) + 'px');
        });

        function calc(y, d, l = 1) {
            let v = y / d;
            return (v > l) ? l : v;
        }
    </script>

    <x-layout.footer/>
</x-layout.layout>
