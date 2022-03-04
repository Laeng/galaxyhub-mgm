<x-theme.galaxyhub.sub-content :title="$title" :description="$title" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin.user', $user->name)">
    <div class="md:flex md:space-x-4">
        <x-panel.galaxyhub.basics class="self-start md:basis-3/5 lg:basis-2/3">
            <div class="">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold">기본 정보</h2>
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">등급</dt>
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">약장</dt>
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

        <div class="self-start p-4 lg:p-8 md:basis-2/5 lg:basis-1/3 flex flex-col space-y-4">
            <div class="flex flex-col space-y-2">
                <h2 class="text-xl lg:text-2xl font-bold">부가 정보 <span class="text-xs font-normal" ></span></h2>

            </div>


        </div>
    </div>

    <script type="text/javascript">
        window.document.addEventListener('alpine:init', () => {
            window.alpine.data('user_read', () => ({
                data: {
                },
                init() {
                    this.load();
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                },
            }));
        });
    </script>
</x-theme.galaxyhub.sub-content>
