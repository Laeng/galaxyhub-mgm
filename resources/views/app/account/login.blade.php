<x-theme.galaxyhub.sub website-name="MGM Lounge" title="로그인" description="MGM Lounge 로그인">
    <x-container.galaxyhub.single align-content="center">
        <div class="w-full flex flex-col lg:flex-row">
            <div class="w-full h-44 lg:h-auto bg-gray-400 block lg:w-1/2 bg-cover bg-center rounded-t-lg lg:rounded-l-lg lg:rounded-tr-none"
                 style="background-image: url('{{ asset('images/background/login.jpg') }}')">
            </div>
            <div class="w-full lg:w-1/2 lg:h-[32rem] bg-white dark:bg-gray-600/10 dark:border dark:border-gray-600 p-5 rounded-b-lg lg:rounded-tr-lg lg:rounded-bl-none">
                <div class="flex flex-col h-full">
                    <div class="grow">
                        <div class="flex items-center justify-center h-full">
                            <div>
                                <h3 class="pt-4 font-bold text-2xl text-indigo-600 text-center">MGM Lounge</h3>
                                <p class="p-4 text-center">
                                    MGM 라운지는 MGM 아르마 클랜 회원님을 위한 공간입니다.
                                    <span class="font-bold">STEAM</span>&reg; 계정으로 로그인 하실 수 있습니다.
                                </p>
                                <div class="flex justify-center pt-4 pb-8 lg:pb-0">
                                    <a href="{{ route('auth.login.provider', 'steam') }}">
                                        <img src="{{asset('images/logo/steam.png')}}" alt="스팀 로그인 버튼"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-6 border-t dark:border-gray-600" />
                    <div class="text-center">
                        <a class="inline-block text-sm text-blue-600 align-baseline hover:text-blue-800 dark:hover:text-blue-400" href="{{ route('welcome') }}">
                            돌아가기
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-container.galaxyhub.single>
</x-theme.galaxyhub.sub>
