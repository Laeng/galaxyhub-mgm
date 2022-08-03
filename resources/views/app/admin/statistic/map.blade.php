@push('js')
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
@endpush

<x-theme.galaxyhub.sub-content title="맵 통계" description="맵 통계" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '맵 통계')">
    <x-panel.galaxyhub.basics>
        <div class="space-y-4" x-data="statistic_map">
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
                        <li><span x-text="data.load.data.total"></span>개 미션에서 사용된 멥 통계입니다.</li>
                    </ul>
                </x-alert.galaxyhub.info>
                <canvas id="addon"></canvas>
            </div>

            <div class="border border-gray-300 dark:border-gray-800 rounded-md w-full overflow-y-auto">

                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap tabular-nums">미션 이름</th>
                        <template x-for="type in data.load.data.map_types">
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap tabular-nums text-center" x-text="type"></th>
                        </template>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    <template x-for="value in data.load.data.values">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 tabular-nums">
                                <a :href="'/app/mission/' + value.id" target="_blank" rel="noopener" class="link-indigo" x-text="value.title"></a>
                            </td>

                            <template x-for="type in data.load.data.map_types">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 tabular-nums text-center">
                                    <input type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" :checked="value.map.includes(type)" disabled/>
                                </td>
                            </template>
                        </tr>
                    </template>
                    </tbody>
                </table>

            </div>
        </div>
        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('statistic_map', () => ({
                    interval: {
                        load: -1
                    },
                    data: {
                        load: {
                            url: '{{ route('admin.statistic.map.data') }}',
                            body: {
                                query: {
                                    start: '{{ today()->subMonth()->format('Y-m-d') }}',
                                    end: '{{ today()->format('Y-m-d') }}'
                                },
                            },
                            data: {
                                total: 0,
                                map_types: [],
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
                                            datasets: [{label: '맵 사용 통계', data: r.data.data.statistic.values, backgroundColor: colors}]
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
