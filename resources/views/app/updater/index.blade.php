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

                <div class="lg:basis-2/5  grid grid-cols-1 gap-4 pt-4 lg:pt-0">
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
                            본 프로그램에 대한 모든 권리는 멀티플레이 게임 매니지먼트와 윤창욱에게 있으며 무단 배포 및 사용을 엄격히 금합니다.
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
                            <x-button.filled.xl-blue class="w-full" @click="() => {location.href=(data.release.data.assets[0].browser_download_url !== '') ? data.release.data.assets[0].browser_download_url : '#'}">
                                <template x-if="data.release.data.assets[0].browser_download_url === ''">
                                    <svg class='spinner h-5' viewBox='0 0 50 50'>
                                        <circle class='path text-white' cx='25' cy='25' r='20' fill='none' stroke-width='4'/>
                                    </svg>
                                </template>
                                <template x-if="data.release.data.assets[0].browser_download_url !== ''">
                                    <p>다운로드</p>
                                </template>
                            </x-button.filled.xl-blue>
                        </div>
                        <!--
                        <div class="flex justify-center lg:block">
                            <x-button.filled.xl-white class="w-full">
                                설치 방법
                            </x-button.filled.xl-white>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        </x-panel.galaxyhub.basics>

        <div class="py-4"></div>

        <x-panel.galaxyhub.basics>
            <div class="">
                <div class="">
                    <div class="border-b border-gray-300 dark:border-gray-800 -mt-2 sm:-mt-4 mb-4">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="data.ui.mode ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = true"> 릴리즈 노트 </button>
                            <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="!data.ui.mode ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = false"> 설치된 PC </button>
                        </nav>
                    </div>
                </div>
                <div>
                    <div class="prose dark:prose-invert prose-sm max-w-full" x-show="data.ui.mode" x-html="data.release.data.body">
                    </div>

                    <div class="" x-show="!data.ui.mode">
                        <div class="mb-4 space-y-2">
                            <x-alert.galaxyhub.info title="MGM Updater 안내">
                                <ul>
                                    <li>최근 6개월 이내에 활성화한 PC 정보를 확인할 수 있습니다.</li>
                                </ul>
                            </x-alert.galaxyhub.info>
                        </div>

                        <div class="bg-white dark:bg-gray-900 overflow-hidden rounded-md border-x border-t border-gray-300 dark:border-gray-800">
                            <ul role="list" class="">
                                <template x-for="updater in data.load.data">
                                    <li class="block font-mono border-b border-gray-300 dark:border-gray-800">
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-indigo-600 truncate uppercase" x-text="updater.code"></p>
                                                <div class="ml-2 flex-shrink-0 flex">
                                                    <template x-if="updater.is_online">
                                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Online</p>
                                                    </template>
                                                    <template x-if="!updater.is_online">
                                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Offline</p>
                                                    </template>
                                                </div>
                                            </div>
                                            <div class="mt-2 sm:flex sm:justify-between">
                                                <div class="sm:flex">
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor">
                                                            <path d="M528 0h-480C21.5 0 0 21.5 0 48v320C0 394.5 21.5 416 48 416h192L224 464H152C138.8 464 128 474.8 128 488S138.8 512 152 512h272c13.25 0 24-10.75 24-24s-10.75-24-24-24H352L336 416h192c26.5 0 48-21.5 48-48v-320C576 21.5 554.5 0 528 0zM512 288H64V64h448V288z"/>
                                                        </svg>
                                                        <p class="uppercase" x-text="updater.name"></p>
                                                    </div>
                                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 640 512">
                                                            <path d="M400 0C426.5 0 448 21.49 448 48V144C448 170.5 426.5 192 400 192H352V224H608C625.7 224 640 238.3 640 256C640 273.7 625.7 288 608 288H512V320H560C586.5 320 608 341.5 608 368V464C608 490.5 586.5 512 560 512H400C373.5 512 352 490.5 352 464V368C352 341.5 373.5 320 400 320H448V288H192V320H240C266.5 320 288 341.5 288 368V464C288 490.5 266.5 512 240 512H80C53.49 512 32 490.5 32 464V368C32 341.5 53.49 320 80 320H128V288H32C14.33 288 0 273.7 0 256C0 238.3 14.33 224 32 224H288V192H240C213.5 192 192 170.5 192 144V48C192 21.49 213.5 0 240 0H400zM256 64V128H384V64H256zM224 448V384H96V448H224zM416 384V448H544V384H416z"/>
                                                        </svg>
                                                        <p class="uppercase" x-text="updater.ip"></p>
                                                    </div>
                                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                            <path d="M7.724 65.49C13.36 55.11 21.79 46.47 32 40.56C39.63 36.15 48.25 33.26 57.46 32.33C59.61 32.11 61.79 32 64 32H448C483.3 32 512 60.65 512 96V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V96C0 93.79 .112 91.61 .3306 89.46C1.204 80.85 3.784 72.75 7.724 65.49V65.49zM48 416C48 424.8 55.16 432 64 432H448C456.8 432 464 424.8 464 416V160H48V416z"/>
                                                        </svg>
                                                        <p x-text="updater.version"></p>
                                                    </div>
                                                </div>
                                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path d="M232 120C232 106.7 242.7 96 256 96C269.3 96 280 106.7 280 120V243.2L365.3 300C376.3 307.4 379.3 322.3 371.1 333.3C364.6 344.3 349.7 347.3 338.7 339.1L242.7 275.1C236 271.5 232 264 232 255.1L232 120zM256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48C141.1 48 48 141.1 48 256z"/>
                                                    </svg>
                                                    <p x-text="updater.updated_at"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </template>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </x-panel.galaxyhub.basics>
    </div>

    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            window.alpine.data('updater', () => ({
                interval: {
                    release: -1,
                    load: -1,
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
                    },
                    load: {
                        url: '{{route('updater.updater')}}',
                        body: {
                            'user_id': {{ $user->id }}
                        },
                        data: {},
                    },
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
                load() {
                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                this.data.load.data = r.data.data;
                            }
                        }
                    };

                    let error = (e) => {
                        console.log(e);
                    };

                    let complete = () => {};

                    this.post(this.data.load.url, this.data.load.body, success, error, complete);

                    if (this.interval.load === -1) {
                        this.interval.load = setInterval(() => {this.post(this.data.load.url, this.data.load.body, success, error, complete)}, 30000);
                    }
                },
                init() {
                    this.release();
                    this.load();
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                }
            }));
        });
    </script>
</x-theme.galaxyhub.sub-content>
