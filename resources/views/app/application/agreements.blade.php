<x-theme.galaxyhub.sub-content title="" description="MGM Lounge 가입">
    <nav class="mb-4" aria-label="Progress">
        <ol role="list" class="border border-gray-300 dark:border-gray-800 rounded-md md:flex shadow-sm bg-white dark:bg-[#080C15]/50">
            <li class="relative md:flex-1 md:flex">
                <div class="group flex items-center w-full">
                    <p class="px-6 py-4 flex items-center text-sm font-medium">
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full border-2 border-blue-600">
                            <span class="text-blue-600">01</span>
                        </span>
                        <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-100">약관 동의</span>
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
        <div class="grid grid-cols-1 gap-8" x-data="agreements_check_account">
            <div>
                <h2 class="text-xl lg:text-2xl font-bold">개인정보처리방침 <span class="text-base font-normal">(필수 동의 항목)</span></h2>
                <div class="mt-2 rounded-md bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-gray-800 dark:text-gray-300">
                    <div class="h-64 px-4" data-simplebar>
                        <div class="prose dark:prose-invert prose-sm max-w-none">
                            @include('components.agreements.privacy')
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-xl lg:text-2xl font-bold">이용약관 <span class="text-base font-normal">(필수 동의 항목)</span></h2>
                <div class="mt-2 rounded-md bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-gray-800 dark:text-gray-300">
                    <div class="h-64 px-4" data-simplebar>
                        <div class="prose dark:prose-invert prose-sm max-w-none">
                            @include('components.agreements.rules')
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: none" class="grid grid-cols-1 gap-4" x-show="(data.check.load && !data.check.status)">
                <x-alert.galaxyhub.danger title="가입 불가 안내">
                    <p x-text="data.check.message"></p>
                </x-alert.galaxyhub.danger>
                <x-alert.galaxyhub.warning title="알려드립니다">
                    스팀 API 문제로 인해 변경된 프로필 또는 구매 내역이 반영 되는데 시간이 다소 걸릴 수 있습니다.
                </x-alert.galaxyhub.warning>
            </div>

            <div style="display: none" class="text-center" x-show="(data.check.load && !data.check.status)">
                <x-button.filled.md-blue type="button" onclick="location.href='{{ route('application.agreements') }}'">
                    새로고침
                </x-button.filled.md-blue>
            </div>

            <div x-show="(!data.check.load || !(data.check.load && !data.check.status))">
                <p class="py-2 text-center">
                    개인정보처리방침 및 이용약관을 읽으셨으며 모두 동의하십니까?
                </p>
                <form action="{{ config('app.config.enable-join-quiz') ? route('application.quiz') : route('application.form')}}" method="post" onsubmit="return (data.check.load && data.check.status)">
                    @csrf
                    <div class="flex justify-center pt-2 space-x-4">
                        <x-button.filled.md-blue
                            x-html="(data.check.load && data.check.status) ? '예, 모두 동의합니다.' : $el.innerHTML">
                            <svg class="spinner h-5" viewBox="0 0 50 50">
                                <circle class="path text-white" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                            </svg>
                        </x-button.filled.md-blue>
                    </div>
                </form>
            </div>
        </div>
    </x-panel.galaxyhub.basics>
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            window.alpine.data('agreements_check_account', () => ({
                data: {
                    check: {
                        load: false,
                        status: false,
                        message: ''
                    }
                },
                check() {
                    let url = '{{route('application.agreement.check.account')}}';
                    let body = {};
                    let success = (r) => {
                        this.data.check.status = r.data.data;
                        this.data.check.message = r.data.description;
                    };
                    let error = (e) => {
                        if (e.response.status === 401) {
                            Location.reload();
                        }

                        if (e.response.status === 415) {
                            //CSRF 토큰 오류 발생
                            window.modal.alert('처리 실패', '로그인 정보를 확인할 수 없습니다.', (c) => {
                                Location.reload();
                            }, 'error');
                            return;
                        }

                        if (e.response.status === 422) {
                            let msg = '';
                            switch (e.response.data.description) {
                                default:
                                    msg = e.response.data.description;
                                    break;
                            }

                            window.modal.alert('처리 실패', msg, (c) => {}, 'error');
                            return;
                        }

                        this.data.check.status = false;
                        this.data.check.message = e.message;
                        console.log(e);
                    };
                    let complete = () => {
                        this.data.check.load = true;
                    };

                    this.post(url, body, success, error, complete)
                },
                init() {
                    this.check();
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                }
            }))
        });
    </script>
</x-theme.galaxyhub.sub-content>
