<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8" x-data="table_simple_{{$componentId}}()">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    @if($useCheckBox)
                        <th scope="col" class="w-4 px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <label :for="'check_' + data.component_id" class="sr-only">전체삭제</label>
                            <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" type="checkbox" :id="'check_' + data.component_id" @click="checkbox()" >
                        </th>
                    @endif

                    <template x-for="field in data.list.data.fields">
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" x-html="field"></th>
                    </template>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="(item, index) in data.list.data.items">
                        <tr>
                            @if($useCheckBox)
                                <td class="w-4 px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <label :for="'check_' + data.component_id + '_' + index" class="sr-only"></label>
                                    <input type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded checkbox" :name="data.check_box_name + '[]'" :value="data.list.data.index[index]" :id="'check_' + data.component_id + '_' + index">
                                </td>
                            @endif
                            <template x-for="value in item">
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500" x-html="value"></td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>

            <nav class="bg-white px-3 py-3 flex items-center justify-between border-t border-gray-200 sm:px-3">
                <div class="hidden sm:block">
                    <p class="text-sm text-gray-700">
                        <span class="font-medium" x-text="(data.list.data.count.step * data.list.data.count.limit) + 1">1</span>
                        -
                        <span class="font-medium" x-text="((data.list.data.count.step + 1) * data.list.data.count.limit <= data.list.data.count.total) ? (data.list.data.count.step + 1) * data.list.data.count.limit : data.list.data.count.total"></span>
                        Total:
                        <span class="font-medium" x-text="data.list.data.count.total"></span>
                    </p>
                </div>
                <div class="flex-1 flex justify-start sm:justify-end space-x-3">
                    <x-button.filled.md-white @click="list(data.list.body.step -= 1)">
                        이전
                    </x-button.filled.md-white>
                    <x-button.filled.md-white @click="list(data.list.body.step += 1)">
                        다음
                    </x-button.filled.md-white>
                </div>
            </nav>
        </div>
    </div>

    <script type="text/javascript">
        function table_simple_{{$componentId}}() {
            return {
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
                        url: '{{ $apiUrl }}',
                        body: {
                            step: 0,
                            limit: 20
                        },
                        data: {
                            fields: {},
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
                    this.data.list.body.step = step;

                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                this.data.list.data = r.data.data;

                                this.data.list.body.step = this.data.list.data.count.step;
                                this.data.list.body.limit = this.data.list.data.count.limit;

                                if (this.interval.list >= 0) {
                                    clearInterval(this.interval.list);
                                }
                            }
                        }
                    }
                    let error = (e) => {
                        console.log(e);
                    }
                    let complete = () => {
                        this.data.list.lock = false;
                    }

                    if (!this.data.list.lock) {
                        this.data.list.lock = true;

                        this.post(this.data.list.url, this.data.list.body, success, error, complete);
                        this.interval.list = setInterval(() => {this.post(this.data.list.url, this.data.list.body, success, error, complete)}, 5000);
                    }
                },
                checkbox() {
                    this.data.checkbox = !this.data.checkbox;
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
            };
        }
    </script>
</div>
