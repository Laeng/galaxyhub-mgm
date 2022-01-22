<x-sub-page website-name="MGM Lounge" title="가입">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center lg:px-48">
        <div class="w-full" x-data="steam_status_check()">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <div class="text-center my-4 lg:mt-0 lg:mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold">
                        약관 동의
                    </h1>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg lg:text-xl font-bold py-2">개인정보처리방침 <span class="text-base font-normal">(필수 동의 항목)</span></h3>
                    <div class="rounded-lg border border-gray-200 py-4 pl-4">
                        <div class="h-64 overflow-y-scroll pr-4">
                            <x-agreement.privacy/>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <h3 class="text-lg lg:text-xl font-bold py-2">이용약관 <span class="text-base font-normal">(필수 동의 항목)</span></h3>
                    <div class="rounded-lg border border-gray-200 py-4 pl-4">
                        <div class="h-64 overflow-y-scroll pr-4">
                            <x-agreement.rules/>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col space-y-2 mb-4" x-show="(data.check.load && !data.check.status)">
                    <x-alert.danger title="가입 불가 안내">
                        <span x-text="data.check.message"></span>
                    </x-alert.danger>
                    <x-alert.warning title="알려드립니다">
                        스팀 API 문제로 인해 변경된 프로필 또는 구매 내역이 반영 되는데 시간이 다소 걸릴 수 있습니다.
                    </x-alert.warning>
                </div>

                <div class="flex justify-center pt-2 space-x-4" style="display: none" x-show="(data.check.load && !data.check.status)">
                    <x-button.filled.md-white type="button" onclick="location.href='{{route('join.agree')}}'">
                        새로고침
                    </x-button.filled.md-white>
                </div>

                <div x-show="(!data.check.load || !(data.check.load && !data.check.status))">
                    <p class="py-2 text-center">
                        개인정보처리방침 및 이용약관을 읽으셨으며 모두 동의하십니까?
                    </p>
                    <form action="{{ route('join.apply') }}" method="post" onsubmit="return (data.check.load && data.check.status)">
                        @csrf
                        <div class="flex justify-center pt-2 space-x-4">
                            <x-button.filled.md-blue x-html="(data.check.load && data.check.status) ? '예, 모두 동의합니다.' : $el.innerHTML">
                                <svg class="spinner h-5" viewBox="0 0 50 50">
                                    <circle class="path text-white" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                                </svg>
                            </x-button.filled.md-blue>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            function steam_status_check(){
                return {
                    data: {
                        check: {
                            load: false,
                            status: false,
                            message: ''
                        }
                    },
                    check() {
                        let url = '{{route('join.validate.steam.api')}}';
                        let body = {};
                        let success = (r) => {
                            this.data.check.status = r.data.data;
                            this.data.check.message = r.data.description;
                        };
                        let error = (e) => {
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
                }
            }
        </script>
    </x-section.basic>
</x-sub-page>
