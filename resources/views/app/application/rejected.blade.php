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

            <li class="hidden relative md:flex-1 md:flex">
                <div class="group flex items-center w-full">
                    <p class="px-6 py-4 flex items-center text-sm font-medium">
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 group-hover:bg-blue-800">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-100">가입 퀴즈 합격!</span>
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

            <li class="hidden relative md:flex-1 md:flex">
                <div class="group flex items-center w-full">
                    <p class="px-6 py-4 flex items-center text-sm font-medium">
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-red-600 group-hover:bg-red-800">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-100">가입 거절</span>
                    </p>
                </div>
            </li>
        </ol>
    </nav>

    <x-panel.galaxyhub.basics class="mb-4">
        <div class="grid grid-cols-1 items-center gap-3">
            <h2 class="text-xl lg:text-2xl font-bold">가입 심사 결과</h2>
            <div>
                <p>
                    가입 신청이 거절되었습니다. <br/>
                    {{ $count }}회 가입 거절 되셨으므로
                    @if($count >= 2)
                        규정에 따라 가입을 하실 수 없습니다.
                    @else
                        {{ $date->format('Y년 m월 d일') }}로부터 30일이 지난 후에 다시 가입을 신청할 수 있습니다.
                    @endif
                    @if(!is_null($reason) && $reason !== '')
                        가입 거절 사유는 다음과 같습니다.
                    @endif
                <p class="font-medium my-4">{{ $reason }}</p>
                <p class="text-sm">"데이터 삭제" 버튼을 통해 가입을 위해 제출한 정보를 삭제할 수 있습니다.<br/> 가입 거절 내역의 경우 개인정보취급방침에 따라 일정 기간 저장 됨을 알려드립니다.</p>
            </div>
            <div class="flex justify-center pt-6 pb-4 lg:pb-0 space-x-2" x-data="account_leave">
                @if($count < 2 &&  $date->diffInDays(\Carbon\Carbon::now(), false) >= 30)
                    <x-button.filled.md-white type="button" onclick="location.href='{{ route('application.agreements') }}'">
                        다시 신청하기
                    </x-button.filled.md-white>
                @endif
                <x-button.filled.md-white onclick="location.href='{{ route('account.leave') }}'">
                    데이터 삭제
                </x-button.filled.md-white>
            </div>
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
