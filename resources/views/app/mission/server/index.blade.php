<x-theme.galaxyhub.sub-content title="미션 서버" description="아르마3 미션 서버" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.mission', '서버')">
    <x-panel.galaxyhub.basics>
        <div class="space-y-8" x-data="mission_server">
            <div class="space-y-2">
                <x-alert.galaxyhub.danger title="아주아주 중요!!!">
                    <ul>
                        <li class="font-bold">서버 사용 후 반드시 이곳에서 서버를 꼭 종료해주세요.</li>
                        <li>원격 데스크탑에서 서버를 종료하면 서버 사용 요금이 계속 부과됩니다!!!</li>
                    </ul>
                </x-alert.galaxyhub.danger>
                <x-alert.galaxyhub.info title="미션 서버 안내">
                    <ul>
                        <li>미션 서버 시작시 IP 주소와 원격 제어 로그인 정보가 변경됩니다.</li>
                    </ul>
                </x-alert.galaxyhub.info>
@if($isAdmin)
                <div style="display: none" x-show="data.cost.data.amount !== ''" x-cloak>
                    <x-alert.galaxyhub.success title="{{ today()->month }}월 1일 부터 {{ today()->month }}월 {{ today()->subDay()->day }}일까지의 사용 금액">
                        <ul>
                            <li>사용 금액: <span x-text="data.cost.data.amount"></span><span x-text="data.cost.data.unit"></span> ({{ today()->addMonth()->month }}월 9일 결제 예정) - <a href="{{ route('admin.budget.live') }}" class="hover:underline">자세히 보기</a></li>
                        </ul>
                    </x-alert.galaxyhub.success>
                </div>
@endif
            </div>

            <div class="space-y-2">
                <h2 class="text-xl lg:text-2xl font-bold">서버 목록 <span class="text-sm" x-text="'(' + data.load.data.count + '개)'"></span></h2>
                <ul role="list" class="grid grid-cols-1 gap-2">

                    <template x-for="server in data.load.data.server">
                        <li class="relative rounded-md border border-gray-300 divide-y divide-gray-300">
                            <div class="w-full flex items-center justify-between py-6 space-x-6">
                                <div class="flex-1 truncate">
                                    <div class="px-6 flex items-center space-x-3">
                                        <h3 class="text-gray-900 font-medium truncate capitalize" x-text="server.name"></h3>
                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="() => { switch (server.code) {case 0: return 'bg-red-100 text-red-800'; case 1: return 'bg-green-100 text-green-800'; case 2: return 'bg-yellow-100 text-yellow-800'; case 3: return 'bg-gray-100 text-gray-800';}}" x-text="server.status"></p>

                                        <!--
                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800"></p>
                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"></p>
                                        -->
                                    </div>
                                    <div class="relative px-2">
                                        <div class="px-4">
                                            <table class="mt-2 text-gray-500 text-sm truncate table-auto font-mono">
                                                <tbody>
                                                <tr>
                                                    <td>IP: </td>
                                                    <td class="select-all" x-text="server.ip !== '' ? server.ip : 'xxx.xxx.xxx.xxx'"></td>
                                                </tr>
                                                <tr>
                                                    <td>ID: </td>
                                                    <td class="select-all" x-text="server.username !== '' ? server.username : 'xxxxxxxx'">galaxyhub</td>
                                                </tr>
                                                <tr>
                                                    <td>PW: </td>
                                                    <td class="select-all" x-text="server.password !== '' ? server.password : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="absolute top-0 px-1 w-full h-full flex justify-center items-center z-10 backdrop-blur-sm" x-show="server.wait || server.code !== 1" x-cloak>
                                            <p x-show="!server.wait && server.code === 0" x-cloak>서버가 시작되면 서버 정보가 표시됩니다.</p>
                                            <p x-show="server.wait || server.code >= 2" x-cloak>잠시 기다려 주십시오.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="-mt-px flex divide-x divide-gray-300">
                                    <div class="w-0 flex-1 flex">
                                        <button class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm font-medium border border-transparent text-gray-500 hover:text-indigo-500 font-bold" @click="process('start', server.name)">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor" >
                                                <path d="M24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13V38.13zM48 432L336 256L48 80V432z"/>
                                            </svg>
                                            <span class="ml-2">시작</span>
                                        </button>
                                    </div>
                                    <div class="w-0 flex-1 flex">
                                        <button class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm font-medium border border-transparent text-gray-500 hover:text-indigo-500 font-bold" @click="process('stop', server.name)">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor">
                                                <path d="M320 64H64c-35.35 0-64 28.65-64 64v255.1c0 35.35 28.65 64 64 64H320c35.35 0 64-28.65 64-64V128C384 92.65 355.3 64 320 64zM336 384c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V128c0-8.822 7.178-16 16-16h256c8.822 0 16 7.178 16 16V384z"/>
                                            </svg>
                                            <span class="ml-2">종료</span>
                                        </button>
                                    </div>
                                    <div class="w-0 flex-1 flex">
                                        <button class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm font-medium border border-transparent text-gray-500 hover:text-indigo-500 font-bold" @click="process('restart', server.name)">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                                                <path d="M496 40v160C496 213.3 485.3 224 472 224h-160C298.8 224 288 213.3 288 200s10.75-24 24-24h100.5C382.8 118.3 322.5 80 256 80C158.1 80 80 158.1 80 256s78.97 176 176 176c41.09 0 81.09-14.47 112.6-40.75c10.16-8.5 25.31-7.156 33.81 3.062c8.5 10.19 7.125 25.31-3.062 33.81c-40.16 33.44-91.17 51.77-143.5 51.77C132.4 479.9 32 379.5 32 256s100.4-223.9 223.9-223.9c79.85 0 152.4 43.46 192.1 109.1V40c0-13.25 10.75-24 24-24S496 26.75 496 40z"/>
                                            </svg>
                                            <span class="ml-2">다시 시작</span>
                                        </button>
                                    </div>
                                    <div class="w-0 flex-1 hidden xl:flex">
                                        <button class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm font-medium border border-transparent text-gray-500 hover:text-indigo-500 font-bold" @click="download(server.name)">
                                            <svg class="w-5 h-5"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                                                <path d="M136.2 150.3L232.2 238.3C237.2 242.9 240 249.3 240 256C240 262.7 237.2 269.1 232.2 273.7L136.2 361.7C126.4 370.6 111.3 369.1 102.3 360.2C93.35 350.4 94.01 335.3 103.8 326.3L180.5 256L103.8 185.7C94.01 176.7 93.35 161.6 102.3 151.8C111.3 142 126.4 141.4 136.2 150.3V150.3zM392 336C405.3 336 416 346.7 416 360C416 373.3 405.3 384 392 384H248C234.7 384 224 373.3 224 360C224 346.7 234.7 336 248 336H392zM448 32C483.3 32 512 60.65 512 96V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H448zM448 80H64C55.16 80 48 87.16 48 96V416C48 424.8 55.16 432 64 432H448C456.8 432 464 424.8 464 416V96C464 87.16 456.8 80 448 80z"/>
                                            </svg>
                                            <span class="ml-2">원격 제어</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>

                </ul>
            </div>
        </div>


        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('mission_server', () => ({
                    interval: {
                        load: -1,
                    },
                    data: {
                        load: {
                            url: '{{ route('mission.server.status') }}',
                            body: {
                                instances: {!! json_encode($instances) !!},
                            },
                            data: {
                                server: [],
                                count: 0
                            }
                        },
@if($isAdmin)
                        cost: {
                            url: '{{ route('mission.server.cost') }}',
                            body: {},
                            data: {
                                amount: '',
                                unit: ''
                            }
                        },
@endif
                        process: {
                            url: '{{ route('mission.server.process') }}',
                            body: {},
                            data: {}
                        }
                    },
                    async load() {
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

                        await this.post(this.data.load.url, this.data.load.body, success, error, complete);

                        if (this.interval.load === -1) {
                            this.interval.load = setInterval(() => {this.post(this.data.load.url, this.data.load.body, success, error, complete)}, 2000);
                        }
                    },
@if($isAdmin)
                    async cost() {
                        let success = (r) => {
                            if (r.data.data !== null) {
                                if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                    this.data.cost.data.amount = r.data.data.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                    this.data.cost.data.unit = r.data.data.unit === 'KRW' ? '원' : r.data.data.unit;
                                }
                            }
                        };

                        let error = (e) => {
                            console.log(e);
                        };

                        let complete = () => {};

                        await this.post(this.data.cost.url, this.data.cost.body, success, error, complete);
                    },
@endif
                    process(type, instanceName) {
                        if(!this.data.load.data.server[instanceName].wait) {
                            if (this.data.load.data.server[instanceName].code === 2 || this.data.load.data.server[instanceName].code === 3)
                            {
                                window.modal.alert('안내', '잠시 기다려 주십시오.', (c) => {}, 'info');
                                return;
                            }

                            this.data.load.data.server[instanceName].wait = true;

                            if (this.data.load.data.server[instanceName].online) {
                                if (type === 'start') {
                                    window.modal.alert('안내', '현재 서버가 실행 중 상태입니다.', (c) => {}, 'info');
                                    return;
                                }
                            }
                            else {
                                if (type === 'stop' || type === 'restart') {
                                    window.modal.alert('안내', '현재 서버가 정지 상태입니다.', (c) => {}, 'info');
                                    return;
                                }
                            }

                            this.data.process.body = {
                                instance_name: instanceName,
                                command: type
                            }

                            let success = (r) => {
                                if (r.data.data !== null) {
                                    if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                        if (r.data.data) {
                                            window.modal.alert('처리 완료', '성공적으로 처리되었습니다.', (c) => {}, 'success');
                                            this.load();
                                        }
                                    }
                                }
                            };

                            let error = (e) => {
                                if (typeof e.response !== 'undefined') {
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
                                }

                                window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                                console.log(e);
                            };

                            let complete = () => {};

                            this.post(this.data.process.url, this.data.process.body, success, error, complete);
                        }
                    },
                    download(instanceName) {
                        if(!this.data.load.data.server[instanceName].wait) {
                            if (this.data.load.data.server[instanceName].code === 2 || this.data.load.data.server[instanceName].code === 3) {
                                window.modal.alert('안내', '잠시 기다려 주십시오.', (c) => {}, 'info');
                                return;
                            }

                            if (this.data.load.data.server[instanceName].code !== 1) {
                                window.modal.alert('안내', '현재 서버가 정지 상태입니다.', (c) => {}, 'info');
                                return;
                            }

                            window.open('{{ route('mission.server.download', '') }}/' + instanceName, '_blank')
                        }
                    },
                    init() {
                        this.load();
@if($isAdmin)
                        this.cost();
@endif
                    },
                    post(url, body, success, error, complete) {
                        window.axios.post(url, body).then(success).catch(error).then(complete);
                    }
                }));
            });
        </script>

    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
