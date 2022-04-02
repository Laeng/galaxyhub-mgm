@push('js')
    <script defer src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
@endpush

<x-theme.galaxyhub.sub-basics title="환영합니다" description="MGM Lounge 메인">
    <div class="py-4 sm:py-6">
        <div class="flex items-center space-x-2 md:space-x-4">
            <img class="rounded-full h-14 w-14" src="{{ $user->avatar }}" alt="프로필 이미지" />
            <div>
                <h1 class="font-bold text-lg">안녕하세요! {{ $user->name }}님.</h1>
                <p class="text-sm text-gray-500 dark:text-gray-300">MGM Lounge 에 오신 것을 환영합니다.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 font-bold rounded-lg border border-gray-300 dark:border-gray-800 mt-5">
            <a href="{{ !is_null($latestUserMission) ? route('mission.read', $latestUserMission->mission_id) : '#' }}" class="p-8 border-b lg:border-b-0 md:border-r border-gray-300 dark:border-gray-800 text-center rounded-t-lg md:rounded-tr-none lg:rounded-bl-lg hover:shadow-inner hover:bg-gray-200 dark:hover:bg-[#080C15]/50">
                <p class="text-sm text-red-600 hover:text-red-700 dark:hover:text-red-500">최근 신청한 미션</p>
                <p class="text-base">{{ !is_null($latestUserMission) ? $latestUserMission->mission->title : '--' }}</p>
            </a>
            <a href="{{ !is_null($attendUserMission) ? route('mission.read', $attendUserMission->mission_id) : '#' }}" class="p-8 border-b lg:border-b-0 lg:border-r border-gray-300 dark:border-gray-800 text-center md:rounded-tr lg:rounded-tr-none hover:shadow-inner hover:bg-gray-200 dark:hover:bg-[#080C15]/50">
                <p class="text-sm text-pink-600 hover:text-pink-700 dark:hover:text-pink-500">최근 참가 미션</p>
                <p class="text-base">{{ !is_null($attendUserMission) ? $attendUserMission->mission->title : '--' }}</p>
            </a>
            <a href="{{ !is_null($latestMission) ? route('mission.read', $latestMission->id) : '#' }}" class="p-8 border-b md:border-b-0 md:border-r border-gray-300 dark:border-gray-800 text-center md:rounded-bl lg:rounded-bl-none hover:shadow-inner hover:bg-gray-200 dark:hover:bg-[#080C15]/50">
                <p class="text-sm text-purple-600 hover:text-purple-700 dark:hover:text-purple-500">예정된 미션</p>
                <p class="text-base">{{ !is_null($latestMission) ? $latestMission->title : '--' }}</p>
            </a>
            <a href="ts3server://ts3.galaxyhub.kr?port=9987" class="p-8 border-gray-300 dark:border-gray-800 text-center rounded-b-lg md:rounded-bl-none lg:rounded-tr-lg hover:shadow-inner hover:bg-gray-200 dark:hover:bg-[#080C15]/50">
                <p class="text-sm text-indigo-600 hover:text-indigo-700 dark:hover:text-indigo-500">팀스피크</p>
                <ul class="text-base">
                    <li>ts3.galaxyhub.kr</li>
                </ul>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-6 gap-4">
            <a class="md:col-span-2 lg:row-span-2 bg-red-500 rounded-lg p-8 lg:p-16 shadow-lg hover:shadow-inner transform hover:translate-y-0.5" href="{{route('mission.index')}}">
                <div class="flex items-center justify-between h-full">
                    <div class="text-left text-white font-bold text-xl lg:text-5xl">
                        <p class="">아르마 3 미션</p>
                        <p class="">참가 신청하기</p>
                    </div>
                    <div class="transform -rotate-12">
                        <svg class="h-10 lg:h-14 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M568 216H576V128c0-35.35-28.65-64-64-64H64C28.65 64 0 92.65 0 128v88h8c22.12 0 40 17.88 40 40S30.13 296 8 296H0V384c0 35.35 28.65 64 64 64h448c35.35 0 64-28.65 64-64V296h-8c-22.12 0-40-17.87-40-39.1S545.9 216 568 216zM528 177.6C499.5 192.3 480 221.9 480 256s19.5 63.75 48 78.38V384c0 8.836-7.164 16-16 16H64c-8.836 0-16-7.164-16-16v-49.63C76.5 319.8 96 290.1 96 256S76.5 192.3 48 177.6V128c0-8.838 7.164-16 16-16h448c8.836 0 16 7.162 16 16V177.6zM416 160H160C142.3 160 128 174.3 128 192v128c0 17.67 14.33 32 32 32h256c17.67 0 32-14.33 32-32V192C448 174.3 433.7 160 416 160zM400 304h-224v-96h224V304z"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <a class="rounded-lg p-8 bg-gradient-to-br from-sky-500/90 to-sky-500 shadow-lg hover:shadow-inner transform hover:translate-y-0.5" href="{{ route('updater.index') }}">
                <div class="flex items-center justify-between">
                    <svg class="h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M448 304h-53.5l-48 48H448c8.822 0 16 7.178 16 16V448c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16v-80C48 359.2 55.18 352 64 352h101.5l-48-48H64c-35.35 0-64 28.65-64 64V448c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64v-80C512 332.7 483.3 304 448 304zM432 408c0-13.26-10.75-24-24-24S384 394.7 384 408c0 13.25 10.75 24 24 24S432 421.3 432 408zM239 368.1C243.7 373.7 249.8 376 256 376s12.28-2.344 16.97-7.031l136-136c9.375-9.375 9.375-24.56 0-33.94s-24.56-9.375-33.94 0L280 294.1V24C280 10.75 269.3 0 256 0S232 10.75 232 24v270.1L136.1 199c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94L239 368.1z"></path>
                    </svg>
                    <div class="text-right text-white h-full">
                        <p class="text-sm">MGM 업데이터</p>
                        <p class="text-2xl font-bold">다운로드</p>
                    </div>
                </div>
            </a>

            <a class="rounded-lg p-8 bg-[#5865F2] shadow-lg hover:shadow-inner transform hover:translate-y-0.5" href="https://discord.gg/mgm" target="_blank">
                <div class="flex items-center justify-between">
                    <svg class="h-10 w-auto text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path fill="currentColor" d="M524.5 69.84a1.5 1.5 0 0 0 -.764-.7A485.1 485.1 0 0 0 404.1 32.03a1.816 1.816 0 0 0 -1.923 .91 337.5 337.5 0 0 0 -14.9 30.6 447.8 447.8 0 0 0 -134.4 0 309.5 309.5 0 0 0 -15.14-30.6 1.89 1.89 0 0 0 -1.924-.91A483.7 483.7 0 0 0 116.1 69.14a1.712 1.712 0 0 0 -.788 .676C39.07 183.7 18.19 294.7 28.43 404.4a2.016 2.016 0 0 0 .765 1.375A487.7 487.7 0 0 0 176 479.9a1.9 1.9 0 0 0 2.063-.676A348.2 348.2 0 0 0 208.1 430.4a1.86 1.86 0 0 0 -1.019-2.588 321.2 321.2 0 0 1 -45.87-21.85 1.885 1.885 0 0 1 -.185-3.126c3.082-2.309 6.166-4.711 9.109-7.137a1.819 1.819 0 0 1 1.9-.256c96.23 43.92 200.4 43.92 295.5 0a1.812 1.812 0 0 1 1.924 .233c2.944 2.426 6.027 4.851 9.132 7.16a1.884 1.884 0 0 1 -.162 3.126 301.4 301.4 0 0 1 -45.89 21.83 1.875 1.875 0 0 0 -1 2.611 391.1 391.1 0 0 0 30.01 48.81 1.864 1.864 0 0 0 2.063 .7A486 486 0 0 0 610.7 405.7a1.882 1.882 0 0 0 .765-1.352C623.7 277.6 590.9 167.5 524.5 69.84zM222.5 337.6c-28.97 0-52.84-26.59-52.84-59.24S193.1 219.1 222.5 219.1c29.67 0 53.31 26.82 52.84 59.24C275.3 310.1 251.9 337.6 222.5 337.6zm195.4 0c-28.97 0-52.84-26.59-52.84-59.24S388.4 219.1 417.9 219.1c29.67 0 53.31 26.82 52.84 59.24C470.7 310.1 447.5 337.6 417.9 337.6z"></path>
                    </svg>
                    <div class="text-right text-white h-full">
                        <p class="text-sm">MGM 디스코드</p>
                        <p class="text-2xl font-bold">바로가기</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 mt-6 gap-4" x-data="app_index">
            <x-panel.galaxyhub.basics>
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold">공지사항</h2>
                </div>
                <div class="mt-4 overflow-y-auto h-96" data-simplebar>
                    <div class="prose prose-sm dark:prose-invert max-w-none pr-3">
                        @include('components.description.lounge-notice')
                    </div>
                </div>
            </x-panel.galaxyhub.basics>

            <x-panel.galaxyhub.basics>
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold">업데이터</h2>
                </div>
                <div class="mt-4 overflow-y-auto h-96" data-simplebar>
                    <div class="prose prose-sm dark:prose-invert max-w-full pr-3" x-html="data.release.data.body"></div>
                </div>
            </x-panel.galaxyhub.basics>
        </div>

        <script type="text/javascript">
            document.addEventListener('alpine:init', () => {
                window.alpine.data('app_index', () => ({
                    interval: {
                        release: -1
                    },
                    data: {
                        ui: {
                            mode: true
                        },
                        release: {
                            url: '{{ route('updater.release') }}',
                            body: {
                                release: false
                            },
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

    </div>
</x-theme.galaxyhub.sub-basics>
