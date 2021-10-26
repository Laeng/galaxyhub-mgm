<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8" x-data="alpinejs_table_simple_{{$componentId}}()">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <form class="overflow-hidden border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    @if($useCheckBox)
                        <th scope="col" class="w-4 px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <label :for="'check_' + data.component_id" class="sr-only">전체삭제</label>
                            <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" type="checkbox" :id="'check_' + data.component_id">
                        </th>
                    @endif

                    <template x-for="field in data.first.data.fields">
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" x-html="field"></th>
                    </template>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="(item, index) in data.first.data.items">
                        <tr>
                            @if($useCheckBox)
                                <td class="w-4 px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <label :for="'check_' + data.component_id + '_' + index" class="sr-only"></label>
                                    <input aria-describedby="comments-description" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" :id="'check_' + data.component_id + '_' + index">
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
                        <span class="font-medium" x-text="(data.first.data.count.offset * data.first.data.count.limit) + 1">1</span>
                        -
                        <span class="font-medium" x-text="((data.first.data.count.offset + 1) * data.first.data.count.limit <= data.first.data.count.total) ? (data.first.data.count.offset + 1) * data.first.data.count.limit : data.first.data.count.total"></span>
                        Total:
                        <span class="font-medium" x-text="data.first.data.count.total"></span>
                    </p>
                </div>
                <div class="flex-1 flex justify-start sm:justify-end">
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        이전
                    </a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        다음
                    </a>
                </div>
            </nav>
        </form>
    </div>

    <script type="text/javascript">
        function alpinejs_table_simple_{{$componentId}}() {
            return {
                interval: {
                    first: -1
                },
                load: {
                    first: false,
                },
                data: {
                    component_id: '{{$componentId}}',
                    first: {
                        url: '{{ $apiUrl }}',
                        body: {
                            offset: 0,
                            limit: 20
                        },
                        data: {
                            fields: {},
                            items: {},
                            count: {
                                offset: 0,
                                limit: 0,
                                total: 0
                            }
                        }
                    }
                },
                first() {
                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                this.data.first = r.data;

                                console.log(r.data);
                                console.log(this.data.first);

                                if (this.interval.first >= 0) {
                                    clearInterval(this.interval.first);
                                }
                            }
                        }
                    }
                    let error = (e) => {
                        console.log(e);
                    }
                    let complete = () => {}

                    this.post(this.data.first.url, this.data.first.body, success, error, complete);
                    //this.interval.first = setInterval(() => {this.post(this.data.first.url, this.data.first.body, success, error, complete)}, 5000);
                },
                init() {
                    this.first();
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                }
            };
        }
    </script>


</div>
