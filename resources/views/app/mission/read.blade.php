@push('js')
    <script defer src="//cdn.embedly.com/widgets/platform.js"></script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('/css/ckeditor.css') }}">
@endpush
<x-theme.galaxyhub.sub-content :title="$type" :description="$mission->title" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.mission', $mission->title)">
    <div class="md:flex md:space-x-4 items-start" x-data="mission_read">
        <x-panel.galaxyhub.basics class="md:basis-3/5 lg:basis-2/3 flex flex-col space-y-8">
            <div class="flex flex-col space-y-2">
                <h2 class="text-xl lg:text-2xl font-bold">{{ $type }} 소개</h2>

                @if($isAdmin && !$isMaker)
                    <x-alert.galaxyhub.danger title="중요">
                        <ul>
                            <li>관리자는 다른 미션 메이커가 생성한 미션을 수정 및 처리할 수 있습니다.</li>
                            <li>{{ $type }} 수정 및 처리 전 반드시 날짜 및 시간 확인바랍니다.</li>
                        </ul>
                    </x-alert.galaxyhub.danger>
                @endif
                @if($isMaker)
                    <x-alert.galaxyhub.info title="미션 메이커님께">
                        <ul>
                            <li>만약 {{ $type }} 시작이 늦을 경우 참가자 분들께 즉시 알려주세요.</li>
                            <li>출석 코드 발급은 {{ $type }} 종료 처리를 해주시면 됩니다.</li>
                            <li>{{ $type }} 종료 처리 이후에는 참가 신청이 안되므로 참가 신청 안하신 분들 참가 신청하도록 안내 부탁드립니다.</li>
                            <li>{{ $type }} 시작 처리 이후에는 {{ $type }} 내용과 시간을 수정할 수 없습니다!</li>
                        </ul>
                    </x-alert.galaxyhub.info>
                @else
                    <x-alert.galaxyhub.info title="지켜주세요!">
                        <ul>
                            <li>아르마 밤 참가 신청 후 불참 또는 지각시 <a href="https://cafe.naver.com/gamemmakers" class="underline hover:no-underline" target="_blank">커뮤니티</a>에 사유를 남겨주세요.</li>
                            <li>DDOS 방지를 위하여 게임 접속 전 스팀 프로필 상태를 오프라인으로 변경해주세요.</li>
                            <li>게임 접속 전 팀스피크 디스크랩션을 읽어주셔야 서버 접속이 가능합니다.</li>
                        </ul>
                    </x-alert.galaxyhub.info>
                @endif
                <template x-if="!data.load.data.is_participant && data.load.data.can_tardy && (data.load.data.phase === 0 || data.load.data.phase === 1)">
                    <x-alert.galaxyhub.success title="참가 신청 가능">
                        <ul>
                            <li>현재 참가 신청 가능한 {{ $type }} 입니다.</li>
                        </ul>
                    </x-alert.galaxyhub.success>
                </template>
                <template x-if="!data.load.data.is_participant && !data.load.data.can_tardy && (data.load.data.phase === 0 || data.load.data.phase === 1)">
                    <x-alert.galaxyhub.warning title="중도 참여 불가">
                        <ul>
                            <li>중도 참여가 불가능한 {{ $type }} 입니다. </li>
                        </ul>
                    </x-alert.galaxyhub.warning>
                </template>
                <template x-if="!data.load.data.is_participant && (data.load.data.phase === -1 || data.load.data.phase === 3)">
                    <x-alert.galaxyhub.warning title="참가 신청 불가">
                        <ul>
                            <li><span x-show="data.load.data.phase === -1">취소된 </span><span x-show="data.load.data.phase === 3">종료된 </span>{{ $type }} 이므로 참가 신청을 할 수 없습니다.</li>
                        </ul>
                    </x-alert.galaxyhub.warning>
                </template>
                <template x-if="data.load.data.is_edit">
                    <x-alert.galaxyhub.warning title="새로고침 필요">
                        <ul>
                            <li>{{ $type }} 소개가 변경되었습니다. - <span class="font-bold text-yellow-700 underline hover:no-underline cursor-pointer" @click="load(true)">새로고침</span></li>
                        </ul>
                    </x-alert.galaxyhub.warning>
                </template>

                <div class="h-fit w-full rounded-md bg-gray-50 dark:border dark:bg-gray-900 dark:border-gray-800 p-4" x-cloak>
                    <div class="ck-content" x-html="data.load.data.body"></div>
                </div>
            </div>

            <div class="flex flex-col space-y-2" x-cloak>
                <h2 class="text-xl lg:text-2xl font-bold">참가자</h2>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    @if($isAdmin)
                        <template x-for="i in data.participants.data.participants">
                            <a :href="'/app/admin/user/' + i.id" rel="noopener" target="_blank" class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-40">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" :src="i.avatar" alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium link-indigo" x-text="i.name"></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-300 truncate tabular-nums" x-text="i.attend + '회 참가'"></p>
                                    <div class="mt-1 flex flex-row flex-wrap">
                                        <template x-for="ii in i.badges">
                                            <img class="h-5 w-5 p-0.5" :alt="ii.name" :title="ii.name" :src="ii.icon">
                                        </template>
                                    </div>
                                </div>
                            </a>
                        </template>
                    @else
                        <template x-for="i in data.participants.data.participants">
                            <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-40">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" :src="i.avatar" alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="i.name"></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-300 truncate tabular-nums" x-text="i.attend + '회 참가'"></p>
                                    <div class="mt-1 flex flex-row flex-wrap">
                                        <template x-for="ii in i.badges">
                                            <img class="h-5 w-5 p-0.5" :alt="ii.name" :title="ii.name" :src="ii.icon">
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    @endif

                </div>
            </div>
        </x-panel.galaxyhub.basics>

        <aside class="md:sticky md:top-[3.75rem] p-4 lg:p-8 md:basis-2/5 lg:basis-1/3 flex flex-col space-y-8" x-cloak>
            <div class="flex flex-col space-y-2">
                <h2 class="text-xl lg:text-2xl font-bold" x-text="(data.load.data.phase === 2) ? '{{ $type }} 출석 마감' : '{{ $type }} 시간'"></h2>
                <div class="mb-3 tabular-nums">
                    <div class="p-4 bg-white border border-gray-300 dark:bg-gray-900 dark:border-gray-800 rounded-lg overflow-hidden shadow-sm tabular-nums">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate" x-text="data.load.data.timestamp.display_date"></dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100" x-text="data.load.data.timestamp.display_time"></dd>
                    </div>
                </div>
            </div>

            @if ($isMaker || $isAdmin)
                <div class="flex flex-col space-y-2">
                    <h2 class="text-xl lg:text-2xl font-bold">출석 코드</h2>
                    <div class="mb-3" >
                        <div class="p-4 bg-white border border-gray-300 dark:bg-gray-900 dark:border-gray-800 rounded-lg overflow-hidden shadow-sm  tabular-nums">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate" x-text="(data.load.data.phase < 2) ? '{{ $type }} 종료 후 발급됩니다.' : '4자리 숫자'">&nbsp;&nbsp;</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100 select-all" :class="{ 'blur': data.load.data.phase < 2 }" x-text="(data.load.data.phase < 2) ? 'XXXX' : data.load.data.code">&nbsp;&nbsp;</dd>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col space-y-2">
                @if($isMaker || $isAdmin)
                    <template x-if="data.load.data.phase === 0">
                        <x-button.filled.md-white class="w-full" type="button" onclick="location.href='{{ route('mission.read.edit', $mission->id) }}'" x-cloak>
                            {{ $type }} 수정
                        </x-button.filled.md-white>
                    </template>
                    <template x-if="data.load.data.phase === 0">
                        <x-button.filled.md-white class="w-full" type="button" @click="process('START')" x-cloak>
                            {{ $type }} 시작
                        </x-button.filled.md-white>
                    </template>
                    <template x-if="data.load.data.phase === 1">
                        <x-button.filled.md-white class="w-full" type="button" @click="process('END')" x-cloak>
                            {{ $type }} 종료
                        </x-button.filled.md-white>
                    </template>
                @endif
                @if(!$isMaker)
                    <template x-if="data.load.data.is_participant && data.load.data.phase === 2" x-cloak>
                        <x-button.filled.md-white class="w-full" type="button" onclick="location.href='{{ route('mission.read.survey', $mission->id) }}'" x-text="data.load.data.button_text">
                        </x-button.filled.md-white>
                    </template>
                    <template x-if="!data.load.data.is_participant && ((data.load.data.can_tardy && data.load.data.phase === 1) || data.load.data.phase === 0)">
                        <x-button.filled.md-white class="w-full" type="button" @click="process('JOIN')" x-cloak>
                            참가 신청
                        </x-button.filled.md-white>
                    </template>
                    <template x-if="data.load.data.is_participant && data.load.data.phase <= 0">
                        <x-button.filled.md-white class="w-full" type="button" @click="process('LEAVE')" x-cloak>
                            참가 취소
                        </x-button.filled.md-white>
                    </template>
                @endif

                <x-button.filled.md-white class="w-full" onclick="location.href='{{ route('mission.index') }}'" type="button" >
                    목록
                </x-button.filled.md-white>
            </div>

            <div class="flex flex-col space-y-2">
                <h2 class="text-xl lg:text-2xl font-bold">정보</h2>
                <ul class="divide-y divide-gray-200 dark:divide-gray-800">
                    <li class="py-4">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                메이커
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ !is_null($maker) ? $maker->name : '탈퇴 회원' }}
                            </p>
                        </div>
                    </li>
                    <li class="py-4" x-cloak="" x-show="data.load.data.status.length > 0">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                미션 상태
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 tabular-nums" x-text="data.load.data.status"></p>
                        </div>
                    </li>
                    <li class="py-4" x-cloak="" x-show="data.load.data.timestamp.created_at.length > 0">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                미션 생성
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 tabular-nums" x-text="data.load.data.timestamp.created_at"></p>
                        </div>
                    </li>
                    <li class="py-4" x-cloak="" x-show="data.load.data.timestamp.started_at.length > 0">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                미션 시작
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 tabular-nums" x-text="data.load.data.timestamp.started_at"></p>
                        </div>
                    </li>
                    <li class="py-4" x-cloak="" x-show="data.load.data.timestamp.ended_at.length > 0">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                미션 종료
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 tabular-nums" x-text="data.load.data.timestamp.ended_at"></p>
                        </div>
                    </li>
                    <li class="py-4" x-cloak="" x-show="data.load.data.timestamp.closed_at.length > 0">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                출석 마감
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 tabular-nums" x-cloak="" x-show="data.load.data.timestamp.closed_at.length > 0" x-text="data.load.data.timestamp.closed_at"></p>
                        </div>
                    </li>
                </ul>
            </div>

            @if($isMaker || $isAdmin)
                <div class="flex flex-col space-y-2">
                    <template x-if="data.load.data.phase === 0">
                        <x-button.filled.md-red class="w-full" type="button" @click="remove()">
                            {{ $type }} 삭제
                        </x-button.filled.md-red>
                    </template>
                    <template x-if="data.load.data.phase === 1">
                        <x-button.filled.md-red class="w-full" type="button" @click="process('CANCEL')">
                            {{ $type }} 취소
                        </x-button.filled.md-red>
                    </template>
                    <template x-if="data.load.data.phase === 3">
                        <x-button.filled.md-blue class="w-full" type="button" onclick="location.href='{{ route('mission.read.report', $mission->id) }}'" x-show="data.load.data.is_survey">
                            만족도 조사 결과
                        </x-button.filled.md-blue>
                    </template>
                </div>
            @endif
        </aside>
    </div>

    <script type="text/javascript">
        window.document.addEventListener('alpine:init', () => {
            window.alpine.data('mission_read', () => ({
                interval: {
                    load: -1,
                    participants: -1,
                },
                data: {
                    load: {
                        url: '{{route('mission.read.refresh', $mission->id)}}',
                        body: {},
                        data: {
                            phase: '{{ $mission->phase }}',
                            status: '{{ $status }}',
                            timestamp: {
                                display_date: '{{ $timestamp->format('Y년 m월 d일') }}',
                                display_time: '{{ $timestamp->format('H시 i분') }}',
                                created_at: '{{ $mission->created_at->format('Y-m-d H:i') }}',
                                started_at: '@if(!is_null($mission->started_at)){{ $mission->started_at->format('Y-m-d H:i') }}@endif',
                                ended_at: '@if(!is_null($mission->ended_at)){{ $mission->ended_at->format('Y-m-d H:i') }}@endif',
                                closed_at: '@if(!is_null($mission->closed_at)){{ $mission->closed_at->format('Y-m-d H:i') }}@endif',
                            },
                            code: '{{ $code }}',
                            body: '{!! $mission->body !!}',
                            can_tardy: {{ var_export($mission->can_tardy) }},
                            is_participant: {{ var_export($isParticipant) }},
                            is_edit: false,
                            is_survey: false,
                            button_text: '',
                        },
                    },
                    participants: {
                        url: '{{ route('mission.read.participants', $mission->id) }}',
                        body: {},
                        data: {
                            participants: []
                        },
                    },
                    remove: {
                        url: '{{ route('mission.delete') }}',
                        body: {
                            id: {{ $mission->id }}
                        },
                        lock: false
                    },
                    process: {
                        url: '{{ route('mission.read.process', $mission->id )}}',
                        body: {
                            type: ''
                        },
                        lock: false
                    }
                },
                remove() {
                    window.modal.confirm('미션 삭제', '정말 삭제하시겠습니까?', (r) => {
                        if (r.isConfirmed) {
                            let success = (r) => {
                                location.href = '{{route('mission.index')}}';
                            }
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
                                            case "MISSION STATUS DOES'T MATCH THE CONDITIONS":
                                                msg = '현재 미션 상태에서 실행할 수 없는 요청입니다.';
                                                break;
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
                            }
                            let complete = () => {
                                this.data.remove.lock = false;
                            }

                            if (!this.data.remove.lock) {
                                this.data.remove.lock = true;
                                this.post(this.data.remove.url, this.data.remove.body, success, error, complete);
                            }
                        }
                    });
                },
                process(type) {
                    this.data.process.body.type = type;

                    let success = (r) => {
                        this.load();
                        this.participants();
                        window.modal.alert('처리 완료', '성공적으로 처리하였습니다.', (c) => {});
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
                                    case "MISSION STATUS DOES'T MATCH THE CONDITIONS":
                                        msg = '현재 미션 상태에서 실행할 수 없는 요청입니다.';
                                        break;
                                    case "REQUIRES 10 PARTICIPATION":
                                        msg = '미션 10회를 참여하셔야만 부트캠프를 신청할 수 있습니다.'
                                        break;
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
                },
                load(update = false) {
                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                if (!update) {
                                    if (this.data.load.data.body !== r.data.data.body) {
                                        this.data.load.data.is_edit = true;
                                        delete r.data.data.body;
                                    }

                                } else {
                                    this.data.load.data.is_edit = false;
                                }

                                this.data.load.data = window._.merge(this.data.load.data, r.data.data);

                                if (update) {
                                    window.alpine.nextTick(() => {
                                        window.global.embedly();
                                    });
                                }
                            }
                        }
                    };

                    let error = (e) => {
                        console.log(e);
                    };

                    let complete = () => {};

                    this.post(this.data.load.url, this.data.load.body, success, error, complete);

                    if (this.interval.load === -1) {
                        this.interval.load = setInterval(() => {this.post(this.data.load.url, this.data.load.body, success, error, complete)}, 30000);
                    }
                },
                participants() {
                    let success = (r) => {
                        if (r.data.data !== null) {
                            if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                this.data.participants.data = r.data.data;
                            }
                        }
                    };

                    let error = (e) => {
                        console.log(e);
                    };

                    let complete = () => {};

                    this.post(this.data.participants.url, this.data.participants.body, success, error, complete);

                    if (this.interval.participants === -1) {
                        this.interval.participants = setInterval(() => {this.post(this.data.participants.url, this.data.participants.body, success, error, complete)}, 30000);
                    }
                },
                init() {
                    this.load();
                    this.participants();
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                }
            }));
        });

        window.addEventListener('load', function(){
            window.global = {
                embedly() {
                    document.querySelectorAll('oembed[url]').forEach(element => {
                        const anchor = document.createElement('a');

                        anchor.setAttribute('href', element.getAttribute('url'));
                        anchor.className = 'embedly-card';

                        element.appendChild(anchor);
                    });
                }
            }

            window.global.embedly();

            embedly("defaults", {
                cards: {
                    align: 'center',
                }
            });
        });
    </script>
</x-theme.galaxyhub.sub-content>
