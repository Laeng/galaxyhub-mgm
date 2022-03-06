<x-theme.galaxyhub.sub-content :title="$title" :description="$title" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin.user', $user->name)">
    <div class="md:flex md:space-x-4 items-start" x-data="user_read">
        <div class="self-start md:basis-3/5 lg:basis-2/3 space-y-8">
            <x-panel.galaxyhub.basics>
                <div class="">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold">기본 정보</h2>
                    </div>
                    <div class="mt-5 border-t border-gray-300 dark:border-gray-800">
                        <dl class="sm:divide-y sm:divide-gray-300 sm:dark:divide-gray-800">
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">닉네임</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $user->name }}</dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">아이디</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $user->username }}</dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Steam&reg; 고유번호</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $steamAccount->account_id }}</dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">권한 [<span class="link-indigo cursor-pointer" @click="edit.group = !edit.group" x-text="!edit.group ? '변경' : '취소'"></span>]</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                    <p x-text="data.load.data.group" x-show="!edit.group"></p>
                                    <div class="flex items-center space-x-2" x-show="edit.group">
                                        <div>
                                            <x-input.select.basics x-model="data.group.body.query.group">
                                                <option value="">권한 선택</option>
                                                <template x-for="(i, v) in data.group.data">
                                                    <option :value="i" x-text="v"></option>
                                                </template>
                                            </x-input.select.basics>
                                        </div>
                                        <x-button.filled.md-white type="button" @click="group()">
                                            변경
                                        </x-button.filled.md-white>
                                    </div>
                                </dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">미션 참가 횟수</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2" x-text="data.load.data.mission_count"></dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">미션 참가 날짜</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2" x-text="data.load.data.mission_date"></dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">약장 [<span class="link-indigo cursor-pointer" @click="edit.badge = !edit.badge" x-text="!edit.badge ? '변경' : '취소'"></span>]</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2" x-show="!edit.badge">
                                    <div class="grid grid-cols-2 gap-2" x-show="data.load.data.badges.length > 0">
                                        <template x-for="badge in data.load.data.badges">
                                            <div class="flex space-x-1 items-center">
                                                <img :alt="badge.name" class="h-4 w-4" :src="badge.icon"/>
                                                <span x-text="badge.name"></span>
                                            </div>
                                        </template>
                                    </div>
                                    <p x-show="data.load.data.badges.length <= 0" x-cloak>획득한 약장 없음</p>
                                </dd>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2" x-show="edit.badge" x-cloak>
                                    <div class="grid grid-cols-2 gap-2 mb-2">
                                        <template x-for="badge in data.badges.data">
                                            <label class="flex space-x-1 items-center">
                                                <input name="badge[]" :value="badge.id" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-800 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring focus:ring-offset-0" type="checkbox" :checked="badge.checked">
                                                <img :alt="badge.name" class="h-4 w-4" :src="badge.icon"/>
                                                <span x-text="badge.name"></span>
                                            </label>
                                        </template>
                                    </div>

                                    <x-button.filled.md-white @click="badge()">
                                        저장
                                    </x-button.filled.md-white>
                                </dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">가입일</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->agreed_at->format('Y-m-d') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>


                <div class="mt-8">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold">부가 정보</h2>
                    </div>
                    <div class="mt-5 border-t border-gray-300 dark:border-gray-800">
                        <dl class="sm:divide-y sm:divide-gray-300 sm:dark:divide-gray-800">
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">네이버 아이디</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $naverId }}</dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">디스코드 사용자명</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $discordName }}</dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">생년월일</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $birthday }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </x-panel.galaxyhub.basics>

            <x-panel.galaxyhub.basics>
                <div>
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold">참가한 미션</h2>
                    </div>

                    <div class="mt-2">
                        <x-list.galaxyhub.basics :component-id="'LIST_' . \Str::upper(\Str::random(6))" :action="route('admin.user.index.list')" :refresh="true" />
                    </div>
                </div>
                <div>
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold">진행한 미션</h2>
                    </div>
                </div>
            </x-panel.galaxyhub.basics>
        </div>


        <aside class="md:sticky md:top-[3.75rem] p-4 lg:p-8 md:basis-2/5 lg:basis-1/3 flex flex-col space-y-8">
            <div class="flex flex-col space-y-2">
                <h2 class="text-xl lg:text-2xl font-bold">부가 정보 <span class="text-xs font-normal" ></span></h2>

            </div>


        </aside>
    </div>

    <script type="text/javascript">
        window.document.addEventListener('alpine:init', () => {
            window.alpine.data('user_read', () => ({
                edit: {
                    badge: false,
                    group: false
                },
                interval: {
                    load: -1,
                    group: -1
                },
                data: {
                    load: {
                        url: '{{ route('admin.user.read.data', $user->id) }}',
                        body: {},
                        data: {
                            group: '{{ $group }}',
                            mission_count: '{{ $missionCount }}',
                            mission_date: '{{ $missionLatest }}',
                            badges: {!! $userBadge !!}
                        },
                    },
                    badges: {
                        url: '{{ route('admin.user.read.badge', $user->id) }}',
                        body: {
                            badges: []
                        },
                        data: {!! $badge !!},
                        lock: false,
                    },
                    group: {
                        url: '{{ route('admin.user.index.process') }}',
                        body: {
                            type: 'group',
                            user_id: [ '{{$user->id}}' ],
                            reason: '',
                            query: {
                                group: ''
                            }
                        },
                        data: {!! $groups !!},
                        lock: false,
                    }
                },
                badge() {
                    this.data.badges.body.badges =  this.checked(document.querySelectorAll("input[name='badge[]']:checked"));

                    let success = (r) => {
                        window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {});

                        this.edit.badge = false;
                        this.load();
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
                        this.data.badges.lock = false;
                    };

                    if (!this.data.badges.lock) {
                        this.data.badges.lock = true;
                        this.post(this.data.badges.url, this.data.badges.body, success, error, complete);
                    }
                },
                group() {
                    let callback = (r) => {
                        if (r.isConfirmed) {
                            this.data.group.body.reason = (r.value.length > 0) ? r.value : '';

                            let success = (r) => {
                                window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {});

                                this.edit.group = false;
                                this.load();
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
                                this.data.group.lock = false;
                            };

                            if (!this.data.group.lock) {
                                this.data.group.lock = true;
                                this.post(this.data.group.url, this.data.group.body, success, error, complete);
                            }
                        }
                    };

                    window.modal.prompt('권한 변경', '변경 사유를 입력해 주십시오.', (v) => {}, callback);
                },
                load() {
                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                this.data.load.data = r.data.data;

                                if (this.interval.load >= 0) {
                                    clearInterval(this.interval.load);
                                }
                            }
                        }
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
                        this.data.badges.lock = false;
                    };

                    if (!this.data.load.lock) {
                        this.post(this.data.load.url, this.data.load.body, success, error, complete);

                        if (this.interval.load === -1)
                        {
                            this.interval.load = setInterval(() => {this.post(this.data.load.url, this.data.load.body, success, error, complete)}, 5000);
                        }
                    }
                },
                init() {

                },
                checkbox(componentId, checked = null) {
                    if (checked == null) {
                        this.data.checkbox = !this.data.checkbox;
                    } else {
                        this.data.checkbox = checked;
                    }

                    let checkboxes = document.querySelectorAll('.' + componentId);
                    [...checkboxes].map((el) => {
                        el.checked = this.data.checkbox;
                    })
                },
                checked(checkboxes) {
                    let checked = [];
                    [...checkboxes].map((el) => {checked.push(el.value);});

                    return checked;
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                },
            }));
        });
    </script>
</x-theme.galaxyhub.sub-content>
