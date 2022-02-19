<x-theme.galaxyhub.sub-content title="" description="MGM Lounge 가입">
    <nav class="mb-4" aria-label="Progress">
        <ol role="list" class="border border-gray-300 dark:border-gray-800 rounded-md divide-y divide-gray-300 dark:divide-gray-800 md:flex md:divide-y-0 shadow-sm bg-white dark:bg-[#080C15]/50">
            <li class="relative md:flex-1 md:flex">
                <div class="group flex items-center w-full">
                    <p class="px-6 py-4 flex items-center text-sm font-medium">
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-500 group-hover:border-gray-400">
                            <span class="text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100">01</span>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100">약관 동의</span>
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
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-500 group-hover:border-gray-400">
                            <span class="text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100">02</span>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100">아르마 퀴즈 참여</span>
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

            <li class="relative md:flex-1 md:flex">
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
        <div class="grid grid-cols-1 items-center gap-3">
            <h1 class="text-xl lg:text-2xl font-bold">
                가입 안내
            </h1>
            <div class="p-4 rounded-md bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-800 my-2">
                <div class="text-gray-700 dark:text-gray-200">
                    <ul>
                        <li>MGM Lounge 및 MGM 아르마 클랜 가입을 진심으로 환영합니다.</li>
                        <li>가입 절차는 <span class="text-sky-400 font-bold">약관 동의 ></span> <span class="text-sky-500 font-bold">ARMA3 퀴즈 참여 ></span> <span class="text-sky-600 font-bold">가입 신청서 작성 ></span> <span class="text-sky-700 font-bold">가입 심사</span> 순으로 진행됩니다.</li>
                        <li>가입 심사는 MGM 아르마 클랜 스탭이 직접 심사하고 있습니다.</li>
                        <li>심사 완료까지 시간이 걸릴 수 있는 점 너른 마음으로 양해해주시면 감사드립니다.</li>
                    </ul>
                </div>
            </div>
            <div class="text-center pt-1 lg:pt-4">
                <x-button.filled.md-blue type="button" onclick="location.href='{{ route('application.agreements') }}'">
                    다음
                </x-button.filled.md-blue>
            </div>
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
