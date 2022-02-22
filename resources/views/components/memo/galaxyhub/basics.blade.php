<div class="flex flex-col space-y-2" x-data="memo_list">
    <div class="flex flex-col space-y-2" x-cloak x-show="finish.list">
        <div class="max-h-96" data-simplebar>
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-800">
                <template x-for="record in data.list.data.records">
                    <li class="py-4">
                        <div class="flex space-x-3">
                            <img class="h-6 w-6 rounded-full" :src="record.recorder.avatar" :alt="record.recorder.name">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium" x-text="record.recorder.name"></h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-300">
                                        <template x-if="record.can_delete">
                                            <span class="link-red cursor-pointer" @click="remove(record.id)" x-cloak>삭제</span>
                                        </template>
                                        <span class="tabular-nums" x-text="record.date"></span>
                                    </p>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    <span class="text-blue-600" x-text="record.type"></span>
                                    <span x-html="record.comment"></span>
                                </p>
                            </div>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
    </div>
    <div x-cloak x-show="!finish.list">
        <p class="text-sm text-gray-500 dark:text-gray-300">
            불러오는 중...
        </p>
    </div>
    <div x-cloak x-show="finish.list">
        <x-input.text.long-text class="h-24" placeholder="작성된 내용은 해당 유저가 볼 수 없습니다. 저장된 내용은 해당 유저 탈퇴 후 5년까지 보관됩니다." x-model="data.create.body.comment"></x-input.text.long-text>
        <x-button.filled.md-blue class="w-full" type="button" @click="create()">등록</x-button.filled.md-blue>
    </div>
</div>

<script type="text/javascript">
    window.document.addEventListener('alpine:init', () => {
        window.alpine.data('memo_list', () => ({
            finish: {
              list: false
            },
            data: {
                list: {
                    url: '{{ route('admin.memo.list') }}',
                    body: {
                        user_id: {{ $userId }}
                    },
                    data: {
                        records: []
                    }
                },
                create: {
                    url: '{{ route('admin.memo.create') }}',
                    body: {
                        user_id: {{ $userId }},
                        comment: ''
                    },
                    lock: false
                },
                delete: {
                    url: '{{ route('admin.memo.delete') }}',
                    body: {
                        user_id: {{ $userId }},
                        memo_id: null,
                    },
                    lock: false
                },
            },
            list() {
                let success = (r) => {
                    if (r.data.data !== null) {
                        if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                            this.data.list.data = r.data.data;
                        }
                    }
                };

                let error = (e) => {
                    if (typeof e.response !== 'undefined') {
                        if (e.response.status === 401) {
                            Location.reload();
                        }

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

                    window.modal.alert('오류', '데이터를 불러오는 도중 문제가 발생하였습니다.', (c) => {}, 'error');
                    console.log(e);
                };

                let complete = () => {
                    this.finish.list = true;
                };

                this.post(this.data.list.url, this.data.list.body, success, error, complete);
            },
            create() {
                if (!this.data.create.lock) {
                    if (this.data.create.body.comment.length > 0) {
                        let success = (r) => {
                            this.data.create.body.comment = '';
                            this.list();
                            window.modal.alert('등록 완료', '정상적으로 처리되었습니다.', (c) => {});
                        }
                        let error = (e) => {
                            window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                            console.log(e);
                        }
                        let complete = () => {
                            this.data.create.lock = false;
                        }

                        this.data.create.lock = true;
                        this.post(this.data.create.url, this.data.create.body, success, error, complete);

                    } else {
                        window.modal.alert('내용 없음', '내용을 입력하여 주십시오', (c) => {}, 'error');
                    }
                }
            },
            remove(id) {
                console.log('dd');
                if (!this.data.delete.lock) {
                    window.modal.confirm('삭제', '메모를 삭제하시겠습니까?', (r) => {
                        if (r.isConfirmed) {
                            this.data.delete.body.memo_id = id;

                            let success = (r) => {
                                window.modal.alert('삭제 완료', '정상적으로 처리되었습니다.', (c) => {});
                                this.list();
                            }
                            let error = (e) => {
                                window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                                console.log(e);
                            }
                            let complete = () => {
                                this.data.delete.lock = false;
                            }

                            this.data.delete.lock = true;
                            this.post(this.data.delete.url, this.data.delete.body, success, error, complete);
                        }
                    }, 'question', '예', '아니요');
                }
            },
            init() {
                this.list();
            },
            post(url, body, success, error, complete) {
                window.axios.post(url, body).then(success).catch(error).then(complete);
            }
        }));
    });
</script>
