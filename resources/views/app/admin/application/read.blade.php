<x-theme.galaxyhub.sub-content :title="$title" :description="$title" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin.application', $user->name)">
    <div class="space-y-2 mb-4">
        @if($isBanned)
            <x-alert.galaxyhub.warning title="주의">
                <p class="font-bold">과거 무기한 활동 정지 이력이 있는 가입 신청자입니다.</p>
            </x-alert.galaxyhub.warning>
        @endif

        @if(!$isBanned && $isRejoin)
            <x-alert.galaxyhub.warning title="주의">
                <p class="font-bold">과거 탈퇴 기록이 있는 가입 신청자 입니다. 활동 기록을 확인하여 주십시오.</p>
            </x-alert.galaxyhub.warning>
        @endif
    </div>

    <div class="md:flex md:space-x-4" x-data="application_read">
        <x-panel.galaxyhub.basics class="self-start md:basis-3/5 lg:basis-2/3">
            <h2 class="text-xl lg:text-2xl font-bold">가입 신청서</h2>
            <x-survey.form :survey="$survey" :answer="$answer"/>
        </x-panel.galaxyhub.basics>

        <div class="self-start p-4 lg:p-8 md:basis-2/5 lg:basis-1/3 flex flex-col space-y-4">
            <div class="flex flex-col space-y-2">
                <h2 class="text-xl lg:text-2xl font-bold">부가 정보 <span class="text-xs font-normal" x-text="data.load.data.created_at"></span></h2>
                <template x-if="data.load.data.summaries.steamid === ''">
                    <x-alert.galaxyhub.danger title="정보 없음">
                        <p>등록된 Steam 정보가 없습니다.</p>
                    </x-alert.galaxyhub.danger>
                </template>
                <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                    <li class="py-4">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                상태
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {!! $status !!}
                            </p>
                        </div>
                    </li>

                    @if ($role !== \App\Enums\RoleType::APPLY)
                        <li class="py-4">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                    담당자
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ !is_null($admin) ? $admin->name : ''  }}
                                </p>
                            </div>
                        </li>
                    @endif

                    <li class="py-4">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                접수 날짜
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $application->created_at->format('Y-m-d h:i') }}
                            </p>
                        </div>
                    </li>

                    @if ($role !== \App\Enums\RoleType::APPLY && !is_null($record))
                        <li class="py-4">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                    처리 날짜
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $record->created_at->format('Y-m-d h:i') }}
                                </p>
                            </div>
                        </li>

                        <li class="py-4">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 pb-2">
                                사유
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $record->data['comment'] === '' ? '등록되지 않음' : $record->data['comment'] }}
                            </p>
                        </li>
                    @endif

                    <li class="py-4">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                아르마3 플레이
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300" x-text="data.load.data.arma.playtime_forever"></p>
                        </div>
                    </li>

                    <li class="py-4">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                차단 기록
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300" x-text="'VAC ' + data.load.data.ban.NumberOfVACBans + '회 / 게임 ' + data.load.data.ban.NumberOfGameBans + '회'"></p>
                        </div>
                    </li>

                    <li class="py-4">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                구입한 게임
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                <a href="{{ route('admin.application.read.games', [$user->id]) }}" target="_blank" rel="noopener">확인하기</a>
                            </p>
                        </div>
                    </li>

                    <li class="py-4">
                        <template x-if="data.load.data.group.length <= 0">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                    가입한 클랜
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    없음
                                </p>
                            </div>
                        </template>
                        <template x-if="data.load.data.group.length > 0">
                            <div x-cloak>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 pb-2">
                                    가입한 그룹 - <a class="text-blue-500 hover:text-blue-800" :href="'https://steamcommunity.com/profiles/' +  data.load.data.summaries.steamid + '/groups/'" target="_blank">더보기</a>
                                </p>
                                <div class="max-h-96" data-simplebar>
                                    <template x-for="i in data.load.data.group">
                                        <a :href="'https://steamcommunity.com/gid/' + i.groupID64" target="_blank">
                                            <div class="flex py-1">
                                                <div class="mr-4 flex-shrink-0">
                                                    <img class="h-16 w-16 rounded" :alt="i.groupName" :src="i.avatarFull"/>
                                                </div>
                                                <div>
                                                    <p class="-mt-1 text-sm font-medium" x-text="i.groupName"></p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-300" x-text="i.summary.replace(/(<([^>]+)>)/ig,'')"></p>
                                                </div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col space-y-2">
                <template x-if="data.load.data.summaries.steamid !== ''">
                    <x-button.filled.md-white @click="window.open('https://steamcommunity.com/profiles/' + data.load.data.summaries.steamid)" type="button">
                        STEAM 프로필 보기
                    </x-button.filled.md-white>
                </template>
                <template x-if="data.load.data.summaries.steamid !== ''">
                    <x-button.filled.md-white @click="window.open('https://steamcommunity.com/profiles/' + data.load.data.summaries.steamid + '/friends')" type="button">
                        STEAM 친구 목록 보기
                    </x-button.filled.md-white>
                </template>
                <template x-if="data.load.data.naver_id !== ''">
                    <x-button.filled.md-white @click="window.open('https://cafe.naver.com/ca-fe/cafes/17091584/members?memberId=' + data.load.data.naver_id)" type="button">
                        네이버 카페 활동 보기
                    </x-button.filled.md-white>
                </template>
            </div>

            <div class="flex flex-col space-y-2">
                <h2 class="text-xl lg:text-2xl font-bold mt-6">활동 기록</h2>
                <x-memo.galaxyhub.basics :user-id="$user->id"/>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                @if ($role === \App\Enums\RoleType::APPLY)
                    <x-button.filled.md-white @click="process('{{ \App\Enums\RoleType::MEMBER->name  }}', '가입 승인', '가입을 승인 하시겠습니까?', false)" type="button">
                        승인
                    </x-button.filled.md-white>
                    <x-button.filled.md-white @click="process('{{ \App\Enums\RoleType::REJECT->name }}', '가입 거절', '거절 사유를 입력해 주십시오.')" type="button">
                        거절
                    </x-button.filled.md-white>
                    <x-button.filled.md-white @click="process('{{ \App\Enums\RoleType::DEFER->name }}', '가입 보류', '보류 사유를 입력해 주십시오.')" type="button">
                        보류
                    </x-button.filled.md-white>
                @endif
                <x-button.filled.md-white onClick="location.href='{{ back()->getTargetUrl() }}'" type="button" class="col-span-3">
                    돌아가기
                </x-button.filled.md-white>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.document.addEventListener('alpine:init', () => {
            window.alpine.data('application_read', () => ({
                interval: {
                    load: -1
                },
                data: {
                    process: {
                        url: '{{ route('admin.application.index.process') }}',
                        body: {},
                        lock: false
                    },
                    load: {
                        url: '{{ route('admin.application.read.data', [$user->id]) }}',
                        body: {},
                        data: {
                            arma: {
                                playtime_forever: '불러오는 중...',
                            },
                            ban: {
                                NumberOfVACBans: '',
                                NumberOfGameBans: ''
                            },
                            group: {
                                groupID64: '',
                                groupDetails: {
                                    groupName: '',
                                    avatarFull: '',
                                    summary: ''
                                }
                            },
                            summaries: {
                                steamid: '',

                            },
                            naver_id: '',
                            created_at: ''
                        }
                    }
                },
                @if($role === \App\Enums\RoleType::APPLY)
                process(type, title, message, prompt = true) {
                    let callback = (r) => {
                        if (r.isConfirmed) {
                            this.data.process.body = {
                                type: type,
                                user_id: ["{{ $user->id }}"],
                                reason: (prompt) ? r.value : null
                            };

                            let success = (r) => {
                                window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {
                                    location.href = '{{ route('admin.application.index') }}';
                                });
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
                @endif
                load() {
                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                this.data.load.data = r.data.data;
                                this.data.load.data.arma.playtime_forever = this.minutesToHm(r.data.data.arma.playtime_forever);

                                if (this.interval.load >= 0) {
                                    clearInterval(this.interval.load);
                                }

                            }
                        }
                    }
                    let error = (e) => {
                        console.log(e);
                    }
                    let complete = () => {}

                    if (!this.data.load.lock) {
                        this.post(this.data.load.url, this.data.load.body, success, error, complete);

                        if (this.interval.load === -1)
                        {
                            this.interval.load = setInterval(() => {this.post(this.data.load.url, this.data.load.body, success, error, complete)}, 5000);
                        }
                    }
                },
                init() {
                    this.load();
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                },
                minutesToHm(minutes) {
                    let h = Math.floor(minutes / 60);
                    let m = Math.floor(minutes % 60);

                    let hd = h > 0 ? h + '시간' : '';
                    let md = m > 0 ? m + '분' : '';

                    return (hd === '' && md === '') ? '0분' : hd + ' ' + md;
                }
            }));
        });
    </script>
</x-theme.galaxyhub.sub-content>
