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
    <div class="" x-cloak x-show="finish.list">
        <div class="relative border border-gray-300 dark:border-gray-800 rounded-lg shadow-sm overflow-hidden focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500" data-simplebar>
            <label for="memo" class="sr-only">Add your comment</label>
            <textarea rows="3" id="memo" x-model="data.create.data.comment" class="block dark:bg-gray-900 w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm" placeholder="작성된 내용은 해당 유저가 볼 수 없습니다. 저장된 내용은 해당 유저 탈퇴 후 5년까지 보관됩니다."></textarea>

            <div class="py-2" aria-hidden="true">
                <!-- Matches height of button in toolbar (1px border + 36px content height) -->
                <div class="py-px">
                    <div class="h-9"></div>
                </div>
            </div>

            <div class="absolute bottom-0 inset-x-0 pr-2 py-2 flex justify-end bg-white dark:bg-gray-900 items-center space-x-2">
                <div>
                    <x-button.filled.md-blue type="button" @click="upload()">
                        이미지
                    </x-button.filled.md-blue>
                </div>
                <div class="flex-shrink-0">
                    <x-button.filled.md-blue type="button" @click="create('text', data.create.data.comment)">
                        등록
                    </x-button.filled.md-blue>
                </div>
            </div>

        </div>
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
                        type: '',
                        user_id: {{ $userId }},
                        comment: ''
                    },
                    data: {
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
            create(type, comment) {
                if (!this.data.create.lock) {
                    if (comment !== undefined && comment.length > 0) {
                        let success = (r) => {
                            this.data.create.data.comment = '';
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

                        this.data.create.body.type = type;
                        this.data.create.body.comment = comment;

                        this.data.create.lock = true;
                        this.post(this.data.create.url, this.data.create.body, success, error, complete);

                    } else {
                        window.modal.alert('내용 없음', '내용을 입력하여 주십시오', (c) => {}, 'error');
                    }
                }
            },
            upload()
            {
                let fire = window.swal.fire({
                    title: '이미지 업로드',
                    html: '<input type="file" name="filepond" id="memo_filepond" value="" multiple data-max-file-size="10MB" data-max-files="10"/>',
                    preConfirm: () => {
                        let files = window.swal.getHtmlContainer().querySelector('#memo_filepond').value;

                        if (files !== undefined && files.length > 0)
                        {
                            this.create('image', files);
                        }

                        return true;
                    },
                    willOpen: () => {
                        FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);
                        let files = [];
                        let pond = FilePond.create(document.querySelector('#memo_filepond'));
                        pond.setOptions({
                            server: {
                                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                                    let cancelToken = axios.CancelToken;
                                    let source = cancelToken.source();

                                    let axios_success = (r) => {
                                        load(r.data.data.id);
                                        files.push(r.data.data.id);

                                        console.log(r.data.data.id);
                                    };
                                    let axios_error = (e) => {
                                        if (typeof e.response !== 'undefined') {
                                            if (e.response.status === 415) {
                                                //CSRF 토큰 오류 발생
                                                error('로그인 정보를 확인할 수 없습니다.');
                                                abort();
                                                return;
                                            }

                                            if (e.response.status === 422) {
                                                let msg = '';
                                                switch (e.response.data.description) {
                                                    default:
                                                        msg = e.response.data.description;
                                                        break;
                                                }

                                                error(msg);
                                                abort();
                                                return;
                                            }
                                        }
                                        error('데이터 처리 중 문제가 발생하였습니다.');
                                        abort();

                                        console.log(e);
                                    };
                                    let axios_complete = () => {};
                                    let axios_config = {
                                        cancelToken: source.token,
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        },
                                        onUploadProgress: (e) => {
                                            progress(e.lengthComputable, e.loaded, e.total);
                                        }
                                    };
                                    let axios_body = new FormData();
                                    axios_body.append(fieldName, file, file.name);

                                    window.axios.post('{{ route('file.upload.filepond', 'memo') }}', axios_body, axios_config).then(axios_success).catch(axios_error).then(axios_complete);

                                    return {
                                        abort: () => {
                                            source.cancel();
                                            abort();
                                        }
                                    };
                                },
                                revert: (id, load, error) => {
                                    let axios_success = (r) => {
                                        load();
                                        files = files.filter((e) => e !== Number(id));
                                    };
                                    let axios_error = (e) => {
                                        if (typeof e.response !== 'undefined') {
                                            if (e.response.status === 415) {
                                                //CSRF 토큰 오류 발생
                                                error('로그인 정보를 확인할 수 없습니다.');
                                                return;
                                            }

                                            if (e.response.status === 422) {
                                                let msg = '';
                                                switch (e.response.data.description) {
                                                    default:
                                                        msg = e.response.data.description;
                                                        break;
                                                }

                                                error(msg);
                                                return;
                                            }
                                        }

                                        error('데이터 처리 중 문제가 발생하였습니다.');
                                        console.log(e);
                                    };
                                    let axios_complete = () => {

                                    };
                                    let axios_body = {
                                        id: id
                                    };

                                    window.axios.post('{{ route('file.delete.filepond', 'memo') }}', axios_body).then(axios_success).catch(axios_error).then(axios_complete);
                                }
                            },
                            acceptedFileTypes: ['image/*']
                        });

                        let memo_filepond = () => {
                            let field = document.querySelector('#memo_filepond');
                            field.value = JSON.stringify(files);
                        };

                        pond.on('processfile', (e) => {
                            memo_filepond();
                        });
                        pond.on('removefile', (e) => {
                            memo_filepond();
                        });
                    },
                });
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

                let filepond_js = [
                    'https://cdn.jsdelivr.net/npm/filepond@4.30.3/dist/filepond.min.js',
                    'https://cdn.jsdelivr.net/npm/filepond-plugin-file-validate-type@1.2.6/dist/filepond-plugin-file-validate-type.min.js',
                    'https://cdn.jsdelivr.net/npm/filepond-plugin-file-validate-size@2.2.5/dist/filepond-plugin-file-validate-size.min.js',
                ]

                let filepond_css = [
                    'https://cdn.jsdelivr.net/npm/filepond@4.30.3/dist/filepond.min.css',
                ]

                if (!Boolean(document.querySelector('script[src="' + filepond_js[0] + '"]'))) {
                    filepond_js.forEach(i => {
                        let script = document.createElement('script');
                        script.src = i;

                        document.head.appendChild(script);
                    });
                }

                if (!Boolean(document.querySelector('link[href="' + filepond_css[0] + '"]'))) {
                    filepond_css.forEach(i => {
                        let link = document.createElement('link');
                        link.href = i;
                        link.rel = 'stylesheet';

                        document.head.appendChild(link);
                    });
                }
            },
            post(url, body, success, error, complete) {
                window.axios.post(url, body).then(success).catch(error).then(complete);
            }
        }));
    });
</script>
