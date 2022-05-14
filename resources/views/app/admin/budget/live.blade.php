<x-theme.galaxyhub.sub-content title="실시간 비용" description="네이버 카페" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin.budget', '실시간 비용')">
    <x-panel.galaxyhub.basics>
        <div class="space-y-4" x-data="budget_live">
            <div>
                <h2 class="text-xl lg:text-2xl font-bold">실시간 비용</h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">현재 사용 중인 서비스에 대한 비용을 확인합니다.</p>
            </div>
            <div class="pt-4">
                <div class="border-b border-gray-300 dark:border-gray-800 -mt-2 sm:-mt-4 mb-4">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="data.ui.mode === 0 ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = 0"> Microsoft Azure </button>
                        <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="data.ui.mode === 1 ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = 1"> Amazon Web Service </button>
                        <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="data.ui.mode === 2 ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = 2"> DigitalOcean </button>
                        <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="data.ui.mode === 3 ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = 3"> Linode </button>
                    </nav>
                </div>
            </div>

            <!--azure -->
            <div x-show="data.ui.mode === 0">
                <div class="space-y-2">
                    <x-alert.galaxyhub.info title="갱신 안내">
                        <ul>
                            <li>Microsoft Azure 정책에 따라 4시간 마다 업데이트됩니다.</li>
                        </ul>
                    </x-alert.galaxyhub.info>
                </div>

                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">이름</th>
                        <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-semibold text-gray-900 sm:table-cell">단위</th>
                        <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-semibold text-gray-900 sm:table-cell">수량</th>
                        <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-semibold text-gray-900 sm:table-cell">단가</th>
                        <th scope="col" class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 sm:pr-6 md:pr-0">금액</th>
                    </tr>
                    </thead>
                    <tbody>

                    <template x-for="(services, serviceName) in data.azure.data.live">
                        <template x-for="(categories, categoryName) in services">
                            <template x-for="(types, typeName) in categories">
                                <template x-for="(item, itemName) in types">

                                    <tr>
                                        <td class="py-4 pl-4 ml-12 pr-3 text-sm sm:pl-6 md:pl-0">
                                            <div class="font-medium text-gray-900" x-text="`${item.category} ${item.name}`"></div>
                                            <div class="mt-0.5 text-gray-500 sm:hidden" x-text="`${splitNumber(item.totalPrice * item.exchangeRate)}원`"></div>
                                        </td>
                                        <td class="hidden py-4 px-3 text-right text-sm text-gray-500 sm:table-cell" x-text="`${item.unitOfMeasure}`"></td>
                                        <td class="hidden py-4 px-3 text-right text-sm text-gray-500 sm:table-cell" x-text="`${item.quantity.toFixed(1)}`"></td>
                                        <td class="hidden py-4 px-3 text-right text-sm text-gray-500 sm:table-cell" x-text="`${splitNumber(item.unitPrice * item.exchangeRate)} 원`"></td>
                                        <td class="py-4 pl-3 pr-4 text-right text-sm text-gray-500 sm:pr-6 md:pr-0" x-text="`${splitNumber(item.totalPrice * item.exchangeRate)} 원`"></td>
                                    </tr>

                                </template>
                            </template>
                        </template>
                    </template>

                    <!-- More projects... -->
                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="row" colspan="4" class="hidden pl-6 pr-3 pt-6 text-right text-sm font-normal text-gray-500 sm:table-cell md:pl-0">소계</th>
                        <th scope="row" class="pl-4 pr-3 pt-6 text-left text-sm font-normal text-gray-500 sm:hidden">소계</th>
                        <td class="pl-3 pr-4 pt-6 text-right text-sm text-gray-500 sm:pr-6 md:pr-0" x-text="`${splitNumber(data.azure.data.calculate.subtotal)} 원`"></td>
                    </tr>
                    <tr>
                        <th scope="row" colspan="4" class="hidden pl-6 pr-3 pt-4 text-right text-sm font-normal text-gray-500 sm:table-cell md:pl-0">세금</th>
                        <th scope="row" class="pl-4 pr-3 pt-4 text-left text-sm font-normal text-gray-500 sm:hidden">세금</th>
                        <td class="pl-3 pr-4 pt-4 text-right text-sm text-gray-500 sm:pr-6 md:pr-0" x-text="`${splitNumber(data.azure.data.calculate.tax)} 원`"></td>
                    </tr>
                    <tr>
                        <th scope="row" colspan="4" class="hidden pl-6 pr-3 pt-4 text-right text-sm font-semibold text-gray-900 sm:table-cell md:pl-0">합계</th>
                        <th scope="row" class="pl-4 pr-3 pt-4 text-left text-sm font-semibold text-gray-900 sm:hidden">합계</th>
                        <td class="pl-3 pr-4 pt-4 text-right text-sm font-semibold text-gray-900 sm:pr-6 md:pr-0" x-text="`${splitNumber(data.azure.data.calculate.subtotal + data.azure.data.calculate.tax)} 원`"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div x-show="data.ui.mode === 1">
                <div class="space-y-2">
                    <x-alert.galaxyhub.info title="연동 예정">
                        <ul>
                            <li>실시간 요금을 확인할 수 있도록 준비중입니다.</li>
                        </ul>
                    </x-alert.galaxyhub.info>
                </div>
            </div>

            <div x-show="data.ui.mode === 2">
                <div class="space-y-2">
                    <x-alert.galaxyhub.info title="연동 예정">
                        <ul>
                            <li>실시간 요금을 확인할 수 있도록 준비중입니다.</li>
                        </ul>
                    </x-alert.galaxyhub.info>
                </div>
            </div>

            <div x-show="data.ui.mode === 3">
                <div class="space-y-2">
                    <x-alert.galaxyhub.info title="연동 예정">
                        <ul>
                            <li>실시간 요금을 확인할 수 있도록 준비중입니다.</li>
                        </ul>
                    </x-alert.galaxyhub.info>
                </div>
            </div>


        </div>
        <script>
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('budget_live', () => ({
                    data:{
                        ui: {
                            mode: 0
                        },
                        azure: {
                            url: '{{ route('admin.budget.live.azure') }}',
                            body: {},
                            data: {
                                live: [],
                                calculate: {
                                    subtotal: 0,
                                    tax: 0
                                },
                            }
                        },
                        aws: {
                            url: '',
                            body: {},
                            data: {}
                        },
                        do: {
                            url: '',
                            body: {},
                            data: {}
                        },
                        linode: {
                            url: '',
                            body: {},
                            data: {}
                        }
                    },
                    async azure() {
                        let success = (r) => {
                            if (r.data.data !== null) {
                                if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                    this.data.azure.data.live = r.data.data;

                                    Object.values(r.data.data).forEach((v, i, a) => {
                                        Object.values(a[i]).forEach((vv, ii, aa) => {
                                            Object.values(aa[ii]).forEach((vvv, iii, aaa) => {
                                                Object.values(aaa[iii]).forEach((vvvv, iiii, aaaa) => {
                                                    this.data.azure.data.calculate.subtotal += vvvv.totalPrice * vvvv.exchangeRate;
                                                });
                                            });
                                        });
                                    });

                                    this.data.azure.data.calculate.tax = this.data.azure.data.calculate.subtotal * 0.1;
                                }
                            }
                        };

                        let error = (e) => {
                            console.log(e);
                        };

                        let complete = () => {};

                        await this.post(this.data.azure.url, this.data.azure.body, success, error, complete);
                    },
                    init() {
                        this.azure();
                    },
                    post(url, body, success, error, complete) {
                        window.axios.post(url, body).then(success).catch(error).then(complete);
                    },
                    splitNumber(number) {
                        number = Math.round(number);
                        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    }
                }));
            });
        </script>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
