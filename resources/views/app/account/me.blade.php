<x-theme.galaxyhub.sub-basics-account :title="$title" :user="$user">
    <x-panel.galaxyhub.basics>
        <div class="">
            <div>
                <h2 class="text-xl lg:text-2xl font-bold">기본 정보</h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">회원님의 MGM Lounge 활동을 기반으로 생성된 정보입니다.</p>
            </div>
            <div class="mt-5 border-t border-gray-300 dark:border-gray-800">
                <dl class="sm:divide-y sm:divide-gray-300 sm:dark:divide-gray-800">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">닉네임</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $user->name }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">아이디</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $user->username }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Steam&reg; 고유번호</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $steamAccount->account_id }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">권한</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $role }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">미션 참가</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $missionCount }}회</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">미션 참가 날짜</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $missionLatest }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">획득한 약장</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                            <ul>
                                <li>[x] 하나</li>
                                <li>[x] 하나</li>
                                <li>[x] 하나</li>
                            </ul>
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">가입일</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->agreed_at->format('Y-m-d') }}</dd>
                    </div>
                </dl>
            </div>
        </div>


        <div class="mt-8">
            <div>
                <h2 class="text-xl lg:text-2xl font-bold">부가 정보</h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">가입 신청서에 기재하신 정보입니다.</p>
            </div>
            <div class="mt-5 border-t border-gray-300 dark:border-gray-800">
                <dl class="sm:divide-y sm:divide-gray-300 sm:dark:divide-gray-800">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">네이버 아이디</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $naverId }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">디스코드 사용자명</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $discordName }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">생년월일</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $birthday }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-basics-account>
