<ul role="list" class="divide-y divide-gray-200"  x-data="memo_list()">
    <template x-for="item in data.list.data.items">
        <li class="relative bg-white py-5 px-4 hover:bg-gray-50">
            <div class="flex justify-between space-x-3">
                <div class="min-w-0 flex-1">
                    <div class="block">
                        <p class="text-sm truncate space-x-1">
                            <span class="font-medium text-gray-900" x-text="item.date"></span>
                            <span class="text-gray-600" x-text="item.sender.nickname"></span>
                        </p>
                    </div>
                </div>
                <template x-if="item.removable">
                    <div class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
                        <button class="hover:text-red-600" type="button" @click="remove(item.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
            <div class="mt-1">
                <p class="line-clamp-2 text-sm text-gray-600" x-text="item.description"></p>
            </div>
        </li>
    </template>


    <li class="relative bg-white pt-5 px-4">
        <div class="border border-gray-300 rounded-lg shadow-sm overflow-hidden focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500">
            <label for="memo" class="sr-only">Add your comment</label>
            <textarea rows="3" id="memo" x-model="data.add.body.content" class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm" placeholder="등록한 내용은 해당 유저와 공유되지 않습니다. 유저 기록은 개인정보취급방침에 따라 해당 회원이 탈퇴한 이후부터 최대 5년까지 저장됩니다."></textarea>

            <div class="py-2" aria-hidden="true">
                <!-- Matches height of button in toolbar (1px border + 36px content height) -->
                <div class="py-px">
                    <div class="h-9"></div>
                </div>
            </div>

            <div class="absolute bottom-0 inset-x-0 pr-6 pb-2 py-2 flex justify-end">
                <div class="flex-shrink-0">
                    <x-button.filled.md-blue type="button" @click="add()">
                        등록
                    </x-button.filled.md-blue>
                </div>
            </div>

        </div>
    </li>
</ul>


<script type="text/javascript">
    function memo_list() {
        return {
            interval: {
                list: -1
            },
            data: {
                list: {
                    url: '{{ route('staff.user.memo.list') }}',
                    body: {
                        user_id: {{ $id }}
                    },
                    data: {
                        items: {}
                    }
                },
                remove: {
                    url: '{{ route('staff.user.memo.remove') }}',
                    body: {
                        user_id: {{ $id }},
                        memo_id: null,
                    },
                    lock: false
                },
                add: {
                    url: '{{ route('staff.user.memo.add') }}',
                    body: {
                        user_id: {{ $id }},
                        content: ''
                    },
                    lock: false
                }
            },
            list() {
                let success = (r) => {
                    if (r.data.data !== null) {
                        if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                            this.data.list.data = r.data.data;

                            if (this.interval.list >= 0) {
                                clearInterval(this.interval.list);
                            }

                        }
                    }
                }
                let error = (e) => {
                    console.log(e);
                }
                let complete = () => {}

                this.post(this.data.list.url, this.data.list.body, success, error, complete);
                this.interval.list = setInterval(() => {this.post(this.data.list.url, this.data.list.body, success, error, complete)}, 5000);
            },
            remove(id) {
                if (!this.data.remove.lock) {
                    window.modal.confirm('삭제', '메모를 삭제하시겠습니까?', (r) => {
                        if (r.isConfirmed) {
                            this.data.remove.body.memo_id = id;

                            let success = (r) => {
                                window.modal.alert('삭제 완료', '정상적으로 처리되었습니다.', (c) => {});
                                this.list();
                            }
                            let error = (e) => {
                                window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                                console.log(e);
                            }
                            let complete = () => {
                                this.data.remove.lock = false;
                            }

                            this.data.remove.lock = true;
                            this.post(this.data.remove.url, this.data.remove.body, success, error, complete);
                        }
                    }, 'question', '예', '아니요');
                }
            },
            add() {
                if (!this.data.add.lock) {
                    if (this.data.add.body.content.length > 0) {
                        let success = (r) => {
                            this.data.add.body.content = '';
                            this.list();
                        }
                        let error = (e) => {
                            window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                            console.log(e);
                        }
                        let complete = () => {
                            this.data.add.lock = false;
                        }

                        this.data.add.lock = true;
                        this.post(this.data.add.url, this.data.add.body, success, error, complete);

                    } else {
                        window.modal.alert('내용 없음', '내용을 입럭하여 주십시오', (c) => {}, 'error');
                    }
                }
            },
            init() {
                this.list();
            },
        }
    }
</script>
