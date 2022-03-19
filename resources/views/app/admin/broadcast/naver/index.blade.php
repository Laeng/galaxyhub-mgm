<x-theme.galaxyhub.sub-content title="네이버 카페" description="회원 목록" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '네이버 카페')">
    <x-panel.galaxyhub.basics>
        <div class="space-y-4">
            <div>
                <h2 class="text-xl lg:text-2xl font-bold">네이버 계정 정보</h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">네이버 카페에 미션 정보를 발행할 네이버 계정 정보입니다. MGM 공용 계정을 등록해 주십시오.</p>
            </div>
            @if(!is_null($account))
                <div class="border-t border-gray-300 dark:border-gray-800">
                    <dl class="sm:divide-y sm:divide-gray-300 sm:dark:divide-gray-800">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">닉네임</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $account->nickname }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">아이디</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $account->account_id }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Access Token</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2 break-all">{{ $account->access_token }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Refresh Token</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2 break-all">{{ $account->refresh_token }}</dd>
                        </div>
                    </dl>
                </div>
            @else
                <div>
                    <p>등록된 계정이 없습니다.</p>
                </div>
            @endif
            <div>
                <x-button.filled.md-white onclick="location.href='{{ route('admin.broadcast.naver.authorize') }}'">
                    네이버 로그인
                </x-button.filled.md-white>
            </div>
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
