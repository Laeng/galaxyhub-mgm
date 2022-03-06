@php
    $componentId = 'LIST_' . \Str::upper(\Str::random(6));
@endphp
<x-theme.galaxyhub.sub-content title="회원" description="회원 목록" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '회원')">
    <x-panel.galaxyhub.basics>
        <div x-data="user_list">

            <div class="rounded border border-gray-300 dark:border-gray-800 p-4 mb-8 w-full">
                <div class="flex items-center space-x-2">
                    <div>
                        <x-input.select.basics id="find" name="find" x-model="data.list.body.query.find" required>
                            <option value="">검색 조건</option>
                            <option value="id64">SteamID64</option>
                            <option value="nickname">STEAM 닉네임</option>
                        </x-input.select.basics>
                    </div>
                    <div class="grow">
                        <x-input.text.basics type="text" class="w-full" id="find_id" name="find_id" x-model="data.list.body.query.find_id" placeholder="회원 검색" @keyup.enter="find()"/>
                    </div>
                    <x-button.filled.md-white @click="find()" type="button">
                        검색
                    </x-button.filled.md-white>
                    <x-button.filled.md-white @click="find(true)" type="button">
                        초기화
                    </x-button.filled.md-white>
                </div>
            </div>

            <div class="xl:ml-auto hidden md:flex items-center space-x-2">
                <div class="w-full lg:w-auto">
                    <x-input.select.basics id="group" name="group" x-model="data.list.body.query.group" required>
                        <option value="">전체 회원</option>
                        @foreach($groups as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </x-input.select.basics>
                </div>
                <div class="w-full lg:w-auto">
                    <x-input.select.basics id="order" name="order" x-model="data.list.body.query.order" required>
                        <option value="">정렬</option>
                        <option value="가입일 오른차순">가입일 오른차순</option>
                        <option value="가입일 내림차순">가입일 내림차순</option>
                        <option value="방문일 오른차순">방문일 오른차순</option>
                        <option value="방문일 내림차순">방문일 내림차순</option>
                        <option value="미션 참가일 오른차순">미션 참가일 오른차순</option>
                        <option value="미션 참가일 내림차순">미션 참가일 내림차순</option>
                    </x-input.select.basics>
                </div>
                <div class="w-full lg:w-auto">
                    <x-input.select.basics id="filter" name="filter" x-model="data.list.body.query.filter" required>
                        <option value="">필터</option>
                        <option value="신규가입 미참여">신규가입 미참여</option>
                        <option value="30일이상 미참여">30일이상 미참여</option>
                    </x-input.select.basics>
                </div>
                <div class="w-full lg:w-auto">
                    <x-input.select.basics id="limit" name="limit" x-model="data.list.body.limit" required>
                        <option value="">보기</option>
                        <option value="10">10명</option>
                        <option value="20">20명</option>
                        <option value="30">30명</option>
                        <option value="50">50명</option>
                    </x-input.select.basics>
                </div>
            </div>

            <div class="my-2">
                <x-list.galaxyhub.basics :component-id="$componentId" name="user_id" :action="route('admin.user.index.list')" :refresh="true"/>
            </div>

            <div class="flex divide-x divide-gray-200 flex-wrap">
                <div class="flex items-center space-x-2 pr-2">
                    <div class="flex items-center space-x-2">
                        <div>
                            <x-input.select.basics id="group" name="group" x-model="data.process.body.query.group" required>
                                <option value="">권한 선택</option>
                                @foreach($groups as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </x-input.select.basics>
                        </div>
                        <x-button.filled.md-white @click="process('group', '권한 변경', '변경 사유를 입력해 주십시오.')" type="button">
                            변경
                        </x-button.filled.md-white>
                    </div>
                </div>
                <div class="flex items-center space-x-2 px-2">
                    <div class="flex items-center space-x-2">
                        <div>
                            <x-input.select.basics id="days" name="days" x-model="data.process.body.query.days" required>
                                <option value="">무기한</option>
                                <option value="1">1일</option>
                                <option value="3">3일</option>
                                <option value="7">7일</option>
                                <option value="14">14일</option>
                                <option value="30">30일</option>
                            </x-input.select.basics>
                        </div>
                        <x-button.filled.md-white @click="process('ban', '활동 정지', '정지 사유를 입력해 주십시오.')" type="button">
                            활동 정지
                        </x-button.filled.md-white>
                    </div>
                    <x-button.filled.md-white @click="process('unban', '활동 정지 해제', '해제 사유를 입력해 주십시오.')" type="button">
                        정지 해제
                    </x-button.filled.md-white>
                </div>
                <div class="flex items-center space-x-2 px-2">
                    <x-button.filled.md-white @click="process('drop', '강제 탈퇴', '강제 탈퇴 사유를 입력해 주십시오.')" type="button">
                        강제 탈퇴
                    </x-button.filled.md-white>
                </div>
            </div>

        </div>

        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('user_list', () => ({
                    data: {
                        list: {
                            body: {
                                limit: 20,
                                query: {
                                    group: '',
                                    order: '가입일 내림차순',
                                    filter: '',
                                    find: '',
                                    find_id: '',
                                },
                            },
                        },
                        process: {
                            lock: false,
                            url: '{{ route('admin.user.index.process') }}',
                            body: {
                                type: '',
                                user_id: [],
                                reason: '',
                                query: {
                                    group: '',
                                    days: ''
                                }
                            }
                        }
                    },
                    process(type, title, message) {
                        let checked = this.checked(document.querySelectorAll("input[name='user_id[]']:checked"));

                        if (checked.length <= 0) {
                            window.modal.alert('오류', '처리할 회원을 선택하여 주십시오.', (c) => {}, 'error');
                            return;
                        }

                        this.data.process.body.type = type;
                        this.data.process.body.user_id = checked;

                        let callback = (r) => {
                            if (r.isConfirmed) {
                                this.data.process.body.reason = (r.value.length > 0) ? r.value : '';

                                let success = (r) => {
                                    window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {});

                                    this.$store.{{$componentId}}.checkbox(false);
                                    this.$store.{{$componentId}}.list(this.$store.{{$componentId}}.data.list.data.count.step);
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

                                let complete = () => {
                                    this.data.process.lock = false;
                                };

                                if (!this.data.process.lock) {
                                    this.data.process.lock = true;
                                    this.post(this.data.process.url, this.data.process.body, success, error, complete);
                                }
                            }
                        };

                        if (prompt) {
                            window.modal.prompt(title, message, (v) => {}, callback);
                        } else {
                            window.modal.confirm(title, message, callback, 'question', '예', '아니요');
                        }
                    },
                    find(init = false) {
                        let table = this.$store.{{$componentId}};

                        if (init) {
                            this.data.list.body.query.find = '';
                            this.data.list.body.query.find_id = '';
                        } else {
                            if (this.data.list.body.query.find.length <= 0) {
                                window.modal.alert('오류', '조건을 선택해 주십시오.', (c) => {}, 'error');
                                return;
                            }
                            if (this.data.list.body.query.find_id.length <= 0) {
                                window.modal.alert('오류', '값을 입력해 주십시오', (c) => {}, 'error');
                                return;
                            }
                        }

                        table.data.list.body.query.find = this.data.list.body.query.find;
                        table.data.list.body.query.find_id = this.data.list.body.query.find_id;
                        table.list();
                    },
                    init() {
                        let table = this.$store.{{$componentId}};

                        this.$watch('data.list.body.limit', (v) => {
                            table.data.list.body.limit = v;
                            table.list();
                        });

                        this.$watch('data.list.body.query.group', (v) => {
                            table.data.list.body.query.group = v;
                            table.list();
                        });

                        this.$watch('data.list.body.query.order', (v) => {
                            table.data.list.body.query.order = v;
                            table.list();
                        });

                        this.$watch('data.list.body.query.filter', (v) => {
                            table.data.list.body.query.filter = v;
                            table.list();
                        });

                    },
                    checked(checkboxes) {
                        let checked = [];
                        [...checkboxes].map((el) => {checked.push(el.value);});

                        return checked;
                    },
                    post(url, body, success, error, complete) {
                        window.axios.post(url, body).then(success).catch(error).then(complete);
                    }
                }));
            });
        </script>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
