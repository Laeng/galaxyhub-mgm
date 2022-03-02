@push('js')
    <script defer src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
@endpush

<x-theme.galaxyhub.sub-content title="MGM 업데이터" description="MGM 업데이터" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app', 'MGM 업데이터')">
    <div  x-data="updater">
        <x-panel.galaxyhub.basics class="space-y-4">
            <div class="">
                <h2 class="text-xl lg:text-2xl font-bold">다운로드</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    최신 MGM 업데이터를 내려받을 수 있습니다.
                </p>
            </div>
            <div class="lg:flex flex-col lg:flex-row  lg:space-x-16 items-center">
                <div class="lg:basis-3/5">
                    <div class="">
                        <img class="" src="{{ asset('images/mgm_updater.png') }}"/>
                    </div>
                </div>

                <div class="lg:basis-2/5 pt-8 pb-4 lg:py-8 grid grid-cols-1 gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-4xl font-black tracking-wide">MGM 업데이터</h1>
                    </div>

                    <div class="">
                        <p class="font-bold">MGM 아르마 클랜 회원분들을 위한 특별한 프로그램</p>
                        <p class="text-sm">Steam Workshop 구독 대신 MGM 업데이터로 편리하게 준비하세요.</p>
                    </div>

                    <div>
                        <p class="text-sm">
                            MGM 업데이터는 수백개의 애드온 파일들을 간편하게 다운로드 받으실 수 있도록 제작되었습니다. 저장 장치의 남은 공간에 따라 필요한 애드온만 다운로드 받거나 무결성 검사를 통해 손상된 애드온을 복구할 수 있습니다.
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-300">
                            MGM 업데이터는 멀티플레이 게임 매니지먼트의 독점 프로그램이며 프로그램에 대한 사용권은 MGM 아르마 클랜 회원과 멀티플레이 게임 매니지먼트가 인가한 외부인에게만 제공됩니다.
                            본 프로그램에 대한 모든 권리는 멀티플레이 게임 매니지먼트와 윤창욱에게 있습니다.
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-300 tabular-nums">
                            <span x-text="data.release.data.published_at"></span>
                            <span x-text="'v' + data.release.data.tag_name"></span>
                        </p>
                    </div>

                    <div class="pt-2 grid grid-cols-1 lg:grid-cols-2 gap-2 lg:w-2/3">
                        <div class="flex justify-center lg:block">
                            <x-button.filled.xl-blue class="w-full" x-html="(data.release.data.assets[0].browser_download_url !== '') ? '다운로드' : $el.innerHTML"
                                                     @click="() => {location.href=(data.release.data.assets[0].browser_download_url !== '') ? data.release.data.assets[0].browser_download_url : '#'}">
                                <svg class="spinner h-5" viewBox="0 0 50 50">
                                    <circle class="path text-white" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                                </svg>
                            </x-button.filled.xl-blue>
                        </div>
                        <div class="flex justify-center lg:block">
                            <x-button.filled.xl-white class="w-full">
                                설치 방법
                            </x-button.filled.xl-white>
                        </div>
                    </div>
                </div>
            </div>
        </x-panel.galaxyhub.basics>

        <div class="py-4"></div>

        <x-panel.galaxyhub.basics>
            <div class="">
                <div class="grid grid-cols-2 gap-1 bg-gray-500 bg-opacity-25 shadow-inner rounded-lg p-1 mb-4">
                    <button type="button" @click="data.ui.mode = true"
                            :class="data.ui.mode ? 'text-black shadow-md bg-white focus:ring-2 ring-offset-1 ring-offset-transparent ring-transparent': 'text-gray-600 hover:text-gray-500 hover:bg-white hover:bg-opacity-50 focus:ring-2 ring-offset-1 ring-offset-transparent ring-transparent'"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md">
                        릴리즈 노트
                    </button>
                    <button type="button" @click="data.ui.mode = false"
                            :class="!data.ui.mode ? 'text-black shadow-md bg-white focus:ring-2 ring-offset-1 ring-offset-transparent ring-transparent': 'text-gray-600 hover:text-gray-500 hover:bg-white hover:bg-opacity-50 focus:ring-2 ring-offset-1 ring-offset-transparent ring-transparent'"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md">
                        설치된 PC
                    </button>
                </div>

                <div>
                    <div class="prose dark:prose-invert prose-sm max-w-full" x-show="data.ui.mode" x-html="data.release.data.body">
                    </div>
                    <div class="prose max-w-full" x-show="!data.ui.mode">
                        kk
                    </div>
                </div>
            </div>
        </x-panel.galaxyhub.basics>
    </div>

    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            window.alpine.data('updater', () => ({
                interval: {
                    release: -1
                },
                data: {
                    ui: {
                        mode: true
                    },
                    release: {
                        url: '{{ route('updater.release') }}',
                        body: {},
                        data: {
                            body: '불러오는 중...',
                            published_at: '0000-00-00',
                            tag_name: '0.0.0',
                            assets: [
                                {
                                    browser_download_url: ''
                                }
                            ]
                        }
                    }
                },
                release() {
                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                this.data.release.data = r.data.data;
                                this.data.release.data.body = marked.parse(this.data.release.data.body);
                            }
                        }
                    };

                    let error = (e) => {
                        console.log(e);
                    };

                    let complete = () => {};

                    this.post(this.data.release.url, this.data.release.body, success, error, complete);

                    if (this.interval.release.load === -1) {
                        this.interval.release.load = setInterval(() => {this.post(this.data.release.url, this.data.release.body, success, error, complete)}, 30000);
                    }
                },
                init() {
                    this.release();
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                }
            }));
        });
    </script>
</x-theme.galaxyhub.sub-content>
