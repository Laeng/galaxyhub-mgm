<x-theme.galaxyhub.sub-content title="" description="MGM Lounge 가입">
    <nav class="mb-4" aria-label="Progress">
        <ol role="list" class="border border-gray-300 dark:border-gray-800 rounded-md md:flex shadow-sm bg-white dark:bg-[#080C15]/50">
            <li class="hidden relative md:flex-1 md:flex">
                <div class="group flex items-center w-full">
                    <p class="px-6 py-4 flex items-center text-sm font-medium">
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 group-hover:bg-blue-800">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-100">약관 동의 완료!</span>
                    </p>
                </div>
                <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
                    <svg class="h-full w-full text-gray-300 dark:text-gray-800" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                        <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round"/>
                    </svg>
                </div>
            </li>

            <li class="relative md:flex-1 md:flex">
                <div class="group flex items-center w-full">
                    <p class="px-6 py-4 flex items-center text-sm font-medium">
                        @if($matches >= 3)
                            <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 group-hover:bg-blue-800">
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-100">가입 퀴즈 합격!</span>
                        @else
                            <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-red-600 group-hover:bg-red-800">
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-100">가입 퀴즈 불합격...</span>
                        @endif
                    </p>
                </div>
                <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
                    <svg class="h-full w-full text-gray-300 dark:text-gray-800" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                        <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round"/>
                    </svg>
                </div>
            </li>

            <li class="hidden relative md:flex-1 md:flex">
                <div class="group flex items-center w-full">
                    <p class="px-6 py-4 flex items-center text-sm font-medium">
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-500 group-hover:border-gray-400">
                            <span class="text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100">03</span>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100">가입 신청서 작성</span>
                    </p>
                </div>
                <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
                    <svg class="h-full w-full text-gray-300 dark:text-gray-800" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                        <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round"/>
                    </svg>
                </div>
            </li>

            <li class="hidden relative md:flex-1 md:flex">
                <div class="group flex items-center w-full">
                    <p class="px-6 py-4 flex items-center text-sm font-medium">
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-500 group-hover:border-gray-400">
                            <span class="text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100">04</span>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100">가입 심사</span>
                    </p>
                </div>
            </li>
        </ol>
    </nav>

    <x-panel.galaxyhub.basics>
        <div class="grid grid-cols-1 gap-8">
            <div class="relative">
                <h1 class="text-xl lg:text-2xl font-bold">
                    퀴즈 결과
                </h1>

                <div class="mt-3 grid grid-cols-1 gap-3">
                    @if($matches >= 3)
                        <x-alert.galaxyhub.success title="축하드립니다!">
                            <ul>
                                <li>{{ $user->name }}님께서는 5개의 문제 중 {{ $matches }}개를 맞추셨습니다!</li>
                                <li>MGM 아르마 클랜을 희망하신다면, 아래의 '가입 신청서 작성하기' 버튼을 눌러주세요.</li>
                                <li>본 퀴즈 결과는 {{ $survey->created_at->copy()->addDays(7)->format('Y년 m월 d일 H시 i분') }}까지 유효합니다. </li>
                            </ul>
                        </x-alert.galaxyhub.success>
                    @else
                        <x-alert.galaxyhub.info title="앗... 이런...">
                            <ul>
                                <li>{{ $user->name }}님께서는 5개의 문제 중 {{ $matches }}개를 맞추셨습니다. 가입을 위해서는 3문제 이상 맞추셔야 합니다.</li>
                                <li>모든 문제는 <a href="https://cafe.naver.com/gamemmakers/book5076085" target="_blank" class="underline hover:no-underline font-bold">아르마 길잡이</a>에서 출제 됩니다.</li>
                                <li>{{ $user->name }}님께서는 운영 정책에 따라 7일 뒤인 {{ $survey->created_at->copy()->addDays(7)->format('Y년 m월 d일 H시 i분') }}에 재도전 하실 수 있습니다.</li>
                            </ul>
                        </x-alert.galaxyhub.info>
                    @endif
                </div>

                @if($matches >= 3)
                    <div class="absolute right-4 md:right-4 xl:right-8 top-4 xl:top-4 -rotate-12 rounded-xl border border-double border-8 border-red-500 mix-blend-multiply dark:mix-blend-normal" style="-webkit-mask-image: url('{{ asset('images/rubber.png') }}'); -webkit-mask-repeat:repeat; -webkit-mask-position: {{mt_rand(0, 64)}}px {{mt_rand(0, 64)}}px;">
                        <div class="p-2 xl:p-4 text-red-500 flex flex-col">
                            <p class="text-4xl xl:text-5xl font-bold lg:font-black">
                                PASSED
                            </p>
                            <p class="text-[0.64rem] lg:text-[0.66rem] xl:text-sm -mt-2">
                                Multiplay Game Management
                            </p>
                        </div>
                    </div>
                @else
                    {{--
                    <div class="absolute right-4 md:right-16 lg:right-0 xl:right-8 top-0 xl:-top-4 -rotate-12 rounded-xl border border-double border-8 border-red-500 mix-blend-multiply" style="-webkit-mask-image: url('{{ asset('image/rubber.png') }}'); -webkit-mask-repeat:repeat; -webkit-mask-position: {{mt_rand(0, 64)}}px {{mt_rand(0, 64)}}px;">
                        <div class="p-2 xl:p-4 text-red-500 flex flex-col">
                            <p class="text-[2.6rem] leading-10 xl:text-[3.4rem] xl:leading-none font-bold lg:font-black">
                                FAILED
                            </p>
                            <p class="text-[0.6rem] lg:text-[0.66rem] xl:text-sm -mt-2">
                                Multiplay Game Management
                            </p>
                        </div>
                    </div>
                    --}}
                @endif
            </div>

            <x-survey.form :survey="$survey" :action="''" :answer="$answer"/>

            @if($matches >= 3)
                <form action="{{ route('application.form') }}" method="post">
                    @csrf
                    <div class="flex justify-center mt-4 space-x-2">
                        <x-button.filled.md-blue type="submit">
                            가입 신청서 작성하기
                        </x-button.filled.md-blue>
                    </div>
                </form>
            @else
                <div class="flex justify-center mt-4 space-x-2">
                    <x-button.filled.md-white type="button" onclick="location.href='{{ route('application.index') }}'">
                        확인
                    </x-button.filled.md-white>
                </div>
            @endif
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
