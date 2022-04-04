<x-theme.galaxyhub.sub-content title="미션 통계" description="애드온 통계" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '애드온 통계')">
    <x-panel.galaxyhub.basics>
        <div class="space-y-4" x-data="updater_users">
            <div>
                <div class="mb-4">
                    <h2 class="text-xl lg:text-2xl font-bold">조건 설정</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                        조건을 선택하여 주십시오.
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <x-input.text.basics type="date" x-model="data.load.body.query.start"/>
                    <p class="text-2xl">~</p>
                    <x-input.text.basics type="date" x-model="data.load.body.query.end"/>
                    <x-button.filled.md-white @click="load()">
                        조회
                    </x-button.filled.md-white>
                </div>
            </div>

            <div class="space-y-4">
                <x-alert.galaxyhub.info title="업데이터 사용자 인증 안내" class="mb-2">
                    <ul>
                        <li><span x-text="data.load.data.total"></span>개가 조회되었습니다.</li>
                    </ul>
                </x-alert.galaxyhub.info>

                <div class="bg-white dark:bg-gray-900 overflow-hidden rounded-md border-x border-t border-gray-300 dark:border-gray-800">
                    <ul role="list" class="">
                        <template x-for="updater in data.load.data.data">
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
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                                                    <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"/>
                                                </svg>
                                                <p>
                                                    <a class="link-indigo" :src="'/app/admin/user/' + updater.user_id" x-text="updater.user_name"></a>
                                                </p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
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
        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('updater_users', () => ({
                    interval: {
                        load: -1
                    },
                    data: {
                        load: {
                            url: '{{ route('admin.updater.users.data') }}',
                            body: {
                                query: {
                                    start: '{{ today()->subWeek()->format('Y-m-d') }}',
                                    end: '{{ today()->format('Y-m-d') }}',
                                },
                            },
                            data: {

                            },
                            lock: false
                        },
                    },
                    chart: {
                        mission: null
                    },
                    load() {
                        let success = (r) => {
                            if (r.data.data !== null) {
                                if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                    this.data.load.data = r.data.data;

                                    if (this.interval.load >= 0) {
                                        clearInterval(this.interval.load);
                                    }
                                }
                            }
                        };

                        let error = (e) => {
                            if (typeof e.response !== 'undefined' && e.response.status === 415) {
                                //CSRF 토큰 오류 발생
                                window.modal.alert('처리 실패', '로그인 정보를 확인할 수 없습니다.', (c) => {
                                    Location.reload();
                                }, 'error');
                                return;
                            }

                            window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                            console.log(e);
                        };

                        let complete = () => {
                            this.data.load.lock = false;
                        };

                        if (!this.data.load.lock) {
                            this.data.load.lock = true;

                            this.post(this.data.load.url, this.data.load.body, success, error, complete);

                            if (this.interval.load === -1)
                            {
                                this.interval.load = setInterval(() => {
                                    this.post(this.data.load.url, this.data.load.body, success, error, complete)
                                }, 5000);
                            }
                        }
                    },
                    init() {
                        this.load();
                    },
                    post(url, body, success, error, complete) {
                        window.axios.post(url, body).then(success).catch(error).then(complete);
                    }
                }));
            });
        </script>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
