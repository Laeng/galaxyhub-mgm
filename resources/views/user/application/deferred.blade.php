<x-theme.galaxyhub.sub-content title="" description="MGM Lounge 가입">
    <nav class="mb-4" aria-label="Progress">
        <ol role="list" class="border border-gray-300 dark:border-gray-800 rounded-md divide-y divide-gray-300 dark:divide-gray-800 md:flex md:divide-y-0 shadow-sm bg-white dark:bg-[#080C15]/50">
            <li class="relative md:flex-1 md:flex">
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
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 group-hover:bg-blue-800">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-100">ARMA3 퀴즈 합격!</span>
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
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 group-hover:bg-blue-800">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-100">가입 신청서 작성 완료!</span>
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
                    <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-red-600 group-hover:bg-red-800">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                    <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-100">가입 보류 됨</span>
                </div>
            </li>
        </ol>
    </nav>

    <x-panel.galaxyhub.basics class="mb-4">
        <x-panel.galaxyhub.basics>
            <div class="grid grid-cols-1 items-center gap-3">
                <h1 class="text-xl lg:text-2xl font-bold">
                    가입 보류 안내
                </h1>
                <x-alert.galaxyhub.warning title="가입이 보류되었습니다.">
                    <ol>
                        @if(!is_null($reason) && $reason !== '')
                            <li>아래 보류 사유를 확인 하신 후 다시 신청해 주시기 바랍니다.</li>
                            <li>{{ $reason }}</li>
                        @endif
                    </ol>
                </x-alert.galaxyhub.warning>
                <div class="text-center pt-1 lg:pt-4">
                    <x-button.filled.md-blue type="button" onclick="location.href='{{ route('application.agreements') }}'">
                        다시 신청하기
                    </x-button.filled.md-blue>
                </div>
            </div>
        </x-panel.galaxyhub.basics>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
