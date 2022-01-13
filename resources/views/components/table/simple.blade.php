<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8" x-data="$store.{{$componentId}}">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="relative overflow-hidden border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                <tr>
                    @if($useCheckBox)
                        <th scope="col" class="w-4 px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                            <label :for="'check_' + data.component_id" class="sr-only">전체삭제</label>
                            <input class="focus:ring-0 focus:ring-offset-0 h-4 w-4 text-indigo-600 border-gray-300 rounded checkbox" type="checkbox" :id="'check_' + data.component_id" @click="checkbox()" >
                        </th>
                    @endif

                    <template x-for="field in data.list.data.fields">
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap" x-html="field"></th>
                    </template>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <template x-for="(item, index) in data.list.data.items">
                    <tr>
                        @if($useCheckBox)
                            <td class="w-4 px-3 py-4 text-sm text-gray-900 whitespace-nowrap">
                                <label :for="'check_' + data.component_id + '_' + index" class="sr-only"></label>
                                <input type="checkbox" class="focus:ring-0 focus:ring-offset-0 h-4 w-4 text-indigo-600 border-gray-300 rounded checkbox" :name="data.check_box_name + '[]'" :value="data.list.data.keys[index]" :id="'check_' + data.component_id + '_' + index">
                            </td>
                        @endif
                        <template x-for="value in item">
                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap tabular-nums" x-html="value"></td>
                        </template>
                    </tr>
                </template>
                </tbody>
            </table>

            <nav class="bg-white px-3 py-3 flex items-center justify-between border-t border-gray-200 sm:px-3">
                <div class="hidden sm:block">
                    <p class="text-sm text-gray-700 tabular-nums">
                        <span class="font-medium" x-text="(data.list.data.count.step >= 0) ? (data.list.data.count.step * data.list.data.count.limit) + 1 : 0"></span>
                        -
                        <span class="font-medium" x-text="((data.list.data.count.step + 1) * data.list.data.count.limit <= data.list.data.count.total) ? (data.list.data.count.step + 1) * data.list.data.count.limit : data.list.data.count.total"></span>
                        Total:
                        <span class="font-medium" x-text="data.list.data.count.total"></span>
                    </p>
                </div>
                <div class="sticky left-0 flex flex-1 justify-start sm:justify-end space-x-3">
                    <x-button.filled.md-white type="button" @click="list(data.list.body.step -= 1)">
                        이전
                    </x-button.filled.md-white>
                    <x-button.filled.md-white type="button" @click="list(data.list.body.step += 1)">
                        다음
                    </x-button.filled.md-white>
                </div>
            </nav>

            <div class="absolute top-0 right-0" x-cloak x-show="load.list">
                <div class="p-2.5 text-gray-500">
                    <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            window.alpine.store('{{$componentId}}', {
                interval: {
                    list: -1
                },
                load: {
                    list: false,
                },
                data: {
                    check_box_name: '{{$checkBoxName}}',
                    component_id: '{{$componentId}}',
                    list: {
                        lock: false,
                        url: '{{$apiUrl}}',
                        body: {
                            step: 0,
                            limit: 20,
                            query: {}
                        },
                        data: {
                            fields: {},
                            keys: {},
                            items: {},
                            count: {
                                step: 0,
                                limit: 0,
                                total: 0
                            }
                        }
                    },
                    checkbox: false
                },
                list(step = 0) {
                    this.load.list = true;
                    this.data.list.body.step = step;

                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                this.data.list.data = r.data.data;

                                this.data.list.body.step = this.data.list.data.count.step;
                                this.data.list.body.limit = this.data.list.data.count.limit;

                                @if(!$refresh)
                                if (this.interval.list >= 0) {
                                    clearInterval(this.interval.list);
                                }
                                @endif
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
                        this.data.list.lock = false;
                        this.load.list = false;
                    };

                    if (!this.data.list.lock) {
                        this.data.list.lock = true;

                        this.post(this.data.list.url, this.data.list.body, success, error, complete);
                        this.interval.list = setInterval(() => {this.post(this.data.list.url, this.data.list.body, success, error, complete)}, 5000);
                    }
                },
                checkbox(checked = null) {
                    if (checked == null) {
                        this.data.checkbox = !this.data.checkbox;
                    } else {
                        this.data.checkbox = checked;
                    }

                    let checkboxes = document.querySelectorAll('.checkbox');
                    [...checkboxes].map((el) => {
                        el.checked = this.data.checkbox;
                    })

                },
                init() {
                    this.list();
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                }
            });
        })
    </script>
</div>
