@push('js')
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
@endpush

<x-theme.galaxyhub.sub-content title="애드온 통계" description="애드온 통계" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '애드온 통계')">
    <x-panel.galaxyhub.basics>
        <div class="space-y-4" x-data="statistic_addon">
            <div>
                <div class="mb-4">
                    <h2 class="text-xl lg:text-2xl font-bold">기간 설정</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                        조회할 기간을 선택하여 주십시오.
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

            <div class="">
                <x-alert.galaxyhub.info title="통계 안내" class="mb-2">
                    <ul>
                        <li><span x-text="data.load.data.total"></span>개 미션에 사용된 애드온 통계입니다.</li>
                    </ul>
                </x-alert.galaxyhub.info>
                <canvas id="addon"></canvas>
            </div>

            <div class="border border-gray-300 dark:border-gray-800 rounded-md ">
                <table class="divide-y divide-gray-300 dark:divide-gray-800 min-w-full">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 p-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">미션</th>
                        <template x-for="type in data.load.data.addon_types">
                            <th scope="col" class="py-3.5 px-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 text-center" x-text="type"></th>
                        </template>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    <template x-for="value in data.load.data.values">
                        <tr>
                            <td class="whitespace-nowrap p-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                <a :href="'/app/mission/' + value.id" target="_blank" rel="noopener" class="link-indigo" x-text="value.title"></a>
                            </td>
                            <template x-for="type in data.load.data.addon_types">
                                <td class="whitespace-nowrap p-4 text-sm font-medium text-gray-900 dark:text-gray-100 text-center"><input type="checkbox" :checked="value.addons.includes(type)" disabled/></td>
                            </template>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('statistic_addon', () => ({
                    interval: {
                        load: -1
                    },
                    data: {
                        load: {
                            url: '{{ route('admin.statistic.addon.data') }}',
                            body: {
                                query: {
                                    start: '{{ today()->subMonth()->format('Y-m-d') }}',
                                    end: '{{ today()->format('Y-m-d') }}'
                                },
                            },
                            data: {
                                total: 0,
                                addon_types: [],
                                values: []
                            },
                            lock: false
                        },
                    },
                    chart: {
                        addon: null
                    },
                    load() {
                        let colors = [
                            '#f87171',
                            '#fb923c',
                            '#fbbf24',
                            '#a3e635',
                            '#34d399',
                            '#22d3ee',
                            '#60a5fa',
                            '#a78bfa',
                            '#e879f9',
                        ];

                        let success = (r) => {
                            if (r.data.data !== null) {
                                if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                    this.data.load.data = r.data.data.data;

                                    if (this.chart.addon !== null) {
                                        this.chart.addon.destroy();
                                    }

                                    this.chart.addon = new Chart('addon', {
                                        type: 'bar',
                                        data: {
                                            labels: r.data.data.statistic.keys,
                                            datasets: [{label: '애드온 사용 통계', data: r.data.data.statistic.values, backgroundColor: colors}]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    suggestedMin: 0,
                                                    suggestedMax: Math.max(r.data.data.statistic.values) + 1,
                                                    ticks: {
                                                        stepSize: 1
                                                    }
                                                }
                                            }
                                        }
                                    });

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
