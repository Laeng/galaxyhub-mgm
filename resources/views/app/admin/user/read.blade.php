@php
    $componentId1 = 'LIST_' . \Str::upper(\Str::random(6));
    $componentId2 = 'LIST_' . \Str::upper(\Str::random(6));
@endphp

<x-theme.galaxyhub.sub-content :title="$title" :description="$title" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin.user', $user->name)">
    <div class="md:flex md:space-x-4 items-start" x-data="user_read">
        <div class="self-start md:basis-3/5 lg:basis-2/3 space-y-8">
            <x-panel.galaxyhub.basics>
                <template x-if="data.load.data.ban !== ''">
                    <div class="space-y-2 mb-8">
                        <div class="rounded-md bg-red-50 dark:bg-gray-900 dark:border dark:border-red-500 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM256 304c13.25 0 24-10.75 24-24v-128C280 138.8 269.3 128 256 128S232 138.8 232 152v128C232 293.3 242.8 304 256 304zM256 337.1c-17.36 0-31.44 14.08-31.44 31.44C224.6 385.9 238.6 400 256 400s31.44-14.08 31.44-31.44C287.4 351.2 273.4 337.1 256 337.1z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-red-800 dark:text-red-200">활동 정지된 회원입니다.</h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                        <ul>
                                            <li>해제 예정 날짜: <span x-text="data.load.data.ban"></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>


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
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                    <a href="https://steamcommunity.com/profiles/{{ $steamAccount->account_id }}" target="_blank" rel="noopener" class="link-indigo">{{ $steamAccount->account_id }}</a></dd>
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
                                                <p x-text="badge.name"></p>
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
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Steam 정보 [<span class="link-indigo cursor-pointer" @click="steam()">갱신</span>]</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                    <template x-if="data.steam.lock">
                                        <svg class='spinner h-5' viewBox='0 0 50 50'>
                                            <circle class='path' cx='25' cy='25' r='20' fill='none' stroke-width='4'/>
                                        </svg>
                                    </template>
                                    <template x-if="!data.steam.lock">
                                        <p x-text="data.load.data.steam_date"></p>
                                    </template>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </x-panel.galaxyhub.basics>

            <x-panel.galaxyhub.basics>
                <div class="space-y-8">
                    <div class="flex flex-col space-y-2">
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold">신청한 미션</h2>
                        </div>
                        <div class="flex items-center">
                            <div class="w-full lg:w-auto mr-2 hidden md:block">
                                <x-input.select.basics id="group" name="group" x-model="data.participate.body.query.type" required>
                                    <option value="">모든 분류</option>
                                    @foreach($types as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </x-input.select.basics>
                            </div>
                            <div class="w-full lg:w-auto md:mr-2">
                                <x-input.select.basics id="limit" name="limit" x-model="data.participate.body.limit" required>
                                    <option value="">보기</option>
                                    <option value="10">10개</option>
                                    <option value="20">20개</option>
                                    <option value="30">30개</option>
                                    <option value="50">50개</option>
                                </x-input.select.basics>
                            </div>
                        </div>
                        <x-list.galaxyhub.basics :component-id="$componentId1" name="" :action="route('admin.user.missions.participate', $user->id)" :refresh="true"/>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold">만든 미션</h2>
                        </div>
                        <div class="flex items-center">
                            <div class="w-full lg:w-auto mr-2 hidden md:block">
                                <x-input.select.basics id="group" name="group" x-model="data.make.body.query.type" required>
                                    <option value="">모든 분류</option>
                                    @foreach($types as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </x-input.select.basics>
                            </div>
                            <div class="w-full lg:w-auto md:mr-2">
                                <x-input.select.basics id="limit" name="limit" x-model="data.make.body.limit" required>
                                    <option value="">보기</option>
                                    <option value="10">10개</option>
                                    <option value="20">20개</option>
                                    <option value="30">30개</option>
                                    <option value="50">50개</option>
                                </x-input.select.basics>
                            </div>
                        </div>
                        <x-list.galaxyhub.basics :component-id="$componentId2" name="" :action="route('admin.user.missions.make', $user->id)" :refresh="true"/>
                    </div>
                </div>
            </x-panel.galaxyhub.basics>

            <x-button.filled.md-white class="w-full" type="button" onclick="location.href='{{ route('admin.application.read', $user->id) }}'">
                가입 신청서 확인
            </x-button.filled.md-white>
        </div>


        <aside class="md:sticky md:top-[3.75rem] p-4 lg:p-8 md:basis-2/5 lg:basis-1/3 flex flex-col space-y-8">
            <div class="flex flex-col space-y-2">
                <h2 class="text-xl lg:text-2xl font-bold">활동 기록</h2>
                <x-memo.galaxyhub.basics :user-id="$user->id"/>
            </div>
            <div class="flex flex-col space-y-2">
                <div class="flex flex-col space-y-2">
                    <h2 class="text-xl lg:text-2xl font-bold">활동 정지</h2>
                </div>
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
                <x-button.filled.md-white @click="process('unban', '활동 정지 해제', '해제 사유를 입력해 주십시오.')" type="button">
                    정지 해제
                </x-button.filled.md-white>
            </div>
            <div class="flex flex-col space-y-2">
                <div class="flex flex-col space-y-2">
                    <h2 class="text-xl lg:text-2xl font-bold">강제 탈퇴</h2>
                </div>
                <x-button.filled.md-white @click="process('drop', '강제 탈퇴', '강제 탈퇴 사유를 입력해 주십시오.')" type="button">
                    강제 탈퇴
                </x-button.filled.md-white>
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
                        url: '{{ route('admin.user.read.data', [$user->id]) }}',
                        body: {},
                        data: {
                            group: '{{ $group }}',
                            mission_count: '{{ $missionCount }}',
                            mission_date: '{{ $missionLatest }}',
                            badges: {!! $userBadge !!},
                            ban: '{{ $ban }}',
                            steam_date: '{{ $steamDataDate }}'
                        },
                    },
                    badges: {
                        url: '{{ route('admin.user.read.badge', [$user->id]) }}',
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
                            user_id: ['{{$user->id}}'],
                            reason: '',
                            query: {
                                group: ''
                            }
                        },
                        data: {!! $groups !!},
                        lock: false,
                    },
                    process: {
                        url: '{{ route('admin.user.index.process') }}',
                        body: {
                            query: {
                                days: ''
                            },
                        },
                        lock: false
                    },
                    participate: {
                        body: {
                            limit: 10,
                            query: {
                                type: ''
                            },
                        },
                    },
                    make: {
                        body: {
                            limit: 10,
                            query: {
                                type: ''
                            },
                        },
                    },
                    steam: {
                        url: '{{ route('admin.application.read.steam', [$user->id]) }}',
                        body: {},
                        lock: false
                    },
                },
                badge() {
                    this.data.badges.body.badges =  this.checked(document.querySelectorAll("input[name='badge[]']:checked"));

                    let success = (r) => {
                        window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {});

                        this.edit.badge = false;
                        this.load();
                        this.$store.memo_list.list();
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
                                this.$store.memo_list.list();
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
                process(type, title, message, prompt = true) {
                    let callback = (r) => {
                        if (r.isConfirmed) {
                            this.data.process.body = {
                                type: type,
                                user_id: ['{{ $user->id }}'],
                                reason: (prompt) ? r.value : null
                            };

                            let success = (r) => {
                                this.load();
                                this.$store.memo_list.list();
                                window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {});
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
                steam() {
                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (r.data.data.result) {
                                window.modal.alert('처리 완료', '스팀 프로필 갱신에 성공하였습니다.', (c) => {
                                    this.load();
                                });
                            } else {
                                window.modal.alert('처리 실패', '스팀 프로필이 비공개 상태입니다.', (c) => {
                                    this.load();
                                }, 'error');
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
                        this.data.steam.lock = false;
                    };

                    if (!this.data.steam.lock) {
                        this.data.steam.lock = true;
                        this.post(this.data.steam.url, this.data.steam.body, success, error, complete);
                    }
                },
                init() {
                    let participate = this.$store.{{$componentId1}};
                    let make = this.$store.{{$componentId2}};

                    this.$watch('data.participate.body.limit', (v) => {
                        participate.data.list.body.limit = v;
                        participate.list();
                    });

                    this.$watch('data.participate.body.query.type', (v) => {
                        participate.data.list.body.query.type = v;
                        participate.list();
                    });

                    this.$watch('data.make.body.limit', (v) => {
                        make.data.list.body.limit = v;
                        make.list();
                    });

                    this.$watch('data.make.body.query.type', (v) => {
                        make.data.list.body.query.type = v;
                        make.list();
                    });

                    participate.list();
                    make.list();
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
