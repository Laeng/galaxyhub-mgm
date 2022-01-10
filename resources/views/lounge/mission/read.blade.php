<x-sub-page website-name="MGM Lounge" title="{{ $mission->title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{ $type }}</h1>

                <div class="grid md:grid-cols-5 lg:grid-cols-3 gap-4" x-data="mission_read">
                    <div class="md:col-span-3 lg:col-span-2">
                        <div>
                            <p class="text-lg font-bold mb-2">{{ $type }} 소개</p>
                            <div class="space-y-3 mb-3">
                                @if($isStaff)
                                    <x-alert.danger title="주의">
                                        <ul>
                                            <li>관리자는 다른 미션 메이커가 생성한 미션을 수정 및 처리할 수 있습니다.</li>
                                            <li>{{ $type }} 수정 및 처리 전 반드시 날짜 및 시간 확인바랍니다.</li>
                                        </ul>
                                    </x-alert.danger>
                                @endif
                                @if($isOwner)
                                    <x-alert.info title="미션 메이커님께">
                                        <ul>
                                            <li>만약 {{ $type }} 시작이 늦을 경우 참가자 분들께 즉시 알려주세요.</li>
                                            <li>출석 코드 발급은 {{ $type }} 종료 처리를 해주시면 됩니다.</li>
                                            <li>{{ $type }} 시작 처리 이후에는 {{ $type }} 내용과 시간을 수정할 수 없습니다!</li>
                                        </ul>
                                    </x-alert.info>
                                @else
                                    <x-alert.info title="지켜주세요!">
                                        <ul>
                                            <li>아르마 밤 참가 신청 후 불참 또는 지각시 커뮤니티에 사유를 남겨주세요.</li>
                                            <li>DDOS 방지를 위하여 게임 접속 전 스팀 프로필 상태를 오프라인으로 변경해주세요.</li>
                                            <li>게임 접속 전 팀스피크 디스크랩션을 읽어주셔야 서버 접속이 가능합니다.</li>
                                        </ul>
                                    </x-alert.info>
                                @endif
                            </div>
                            <div class="h-fit w-full rounded-md bg-gray-50 p-4">
                                <div class="mission-body prose max-w-full" x-html="data.load.data.body"></div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <p class="text-lg font-bold mb-2">{{ $type }} 참가자</p>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <template x-for="i in data.participants.data.participants">
                                    <div class="relative rounded-lg border border-gray-200 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-40">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" :src="i.avatar" alt="">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-gray-900" x-text="i.nickname"></p>
                                            <p class="text-sm text-gray-500 truncate" x-text="i.attend + '회 참가'"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2 lg:col-span-1">
                        <p class="text-lg font-bold mb-2" x-text="(data.load.data.phase === 2) ? '{{ $type }} 출석 마감' : '{{ $type }} 시간'"></p>
                        <div class="mb-3">
                            <div class="p-4 bg-gray-50 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate" x-text="data.load.data.timestamp.display_date"></dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900" x-text="data.load.data.timestamp.display_time"></dd>
                            </div>
                        </div>

                        @if ($isOwner)
                            <p class="text-lg font-bold mb-2">{{ $type }} 출석 코드</p>
                            <div class="mb-3">
                                <div class="p-4 bg-gray-50 rounded-lg overflow-hidden">
                                    <dt class="text-sm font-medium text-gray-500 truncate" x-text="(data.load.data.phase < 2) ? '{{ $type }} 종료 후 발급됩니다.' : '4자리 숫자'"></dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900" :class="{ 'blur': data.load.data.phase < 2 }" x-text="(data.load.data.phase < 2) ? 'XXXX' : data.load.data.code"></dd>
                                </div>
                            </div>
                        @endif

                        <div class="mb-6 space-y-2">
                            @if($isOwner)
                                <template x-if="data.load.data.phase === 0">
                                    <x-button.filled.md-white class="w-full" type="button" onclick="location.href='{{ route('lounge.mission.update', $id) }}'" x-cloak>
                                        {{ $type }} 수정
                                    </x-button.filled.md-white>
                                </template>
                                <template x-if="data.load.data.phase === 0">
                                    <x-button.filled.md-white class="w-full" type="button" @click="process('start')" x-cloak>
                                        {{ $type }} 시작
                                    </x-button.filled.md-white>
                                </template>
                                <template x-if="data.load.data.phase === 1">
                                    <x-button.filled.md-white class="w-full" type="button" @click="process('end')" x-cloak>
                                        {{ $type }} 종료
                                    </x-button.filled.md-white>
                                </template>
                            @else
                                <template x-if="data.load.data.is_participant && data.load.data.phase === 2">
                                    <x-button.filled.md-blue class="w-full" type="button">
                                        출석 체크
                                    </x-button.filled.md-blue>
                                </template>
                                <template x-if="!data.load.data.is_participant && ((data.load.data.can_tardy === 1 && data.load.data.phase === 1) || data.load.data.phase === 0)">
                                    <x-button.filled.md-blue class="w-full" type="button">
                                        참가 신청
                                    </x-button.filled.md-blue>
                                </template>
                                <template x-if="data.load.data.is_participant">
                                    <x-button.filled.md-blue class="w-full" type="button">
                                        참가 취소
                                    </x-button.filled.md-blue>
                                </template>
                            @endif

                            <x-button.filled.md-white class="w-full" onclick="location.href='{{ route('lounge.mission.list') }}'" type="button" >
                                목록
                            </x-button.filled.md-white>
                        </div>

                        <div class="mb-3">
                            <p class="text-lg font-bold">{{ $type }} 정보</p>
                            <ul class="divide-y divide-gray-200">

                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            미션 상태
                                        </p>
                                        <p class="text-sm text-gray-600" x-text="data.load.data.status"></p>
                                    </div>
                                </li>

                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            메이커
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $maker->nickname }}
                                        </p>
                                    </div>
                                </li>

                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            미션 생성
                                        </p>
                                        <p class="text-sm text-gray-600" x-text="data.load.data.timestamp.created_at"></p>
                                    </div>
                                </li>

                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            미션 시작
                                        </p>
                                        <p class="text-sm text-gray-600" x-text="data.load.data.timestamp.started_at"></p>
                                    </div>
                                </li>

                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            미션 종료
                                        </p>
                                        <p class="text-sm text-gray-600" x-text="data.load.data.timestamp.ended_at"></p>
                                    </div>
                                </li>

                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            출석 마감
                                        </p>
                                        <p class="text-sm text-gray-600" x-text="data.load.data.timestamp.closed_at"></p>
                                    </div>
                                </li>

                            </ul>
                        </div>

                        @if($isOwner)
                            <div class="space-y-2">
                                <template x-if="data.load.data.phase === 0">
                                    <x-button.filled.md-red class="w-full" type="button" @click="remove()">
                                        {{ $type }} 삭제
                                    </x-button.filled.md-red>
                                </template>
                                <template x-if="data.load.data.phase === 1">
                                    <x-button.filled.md-red class="w-full" type="button" @click="process('cancel')">
                                        {{ $type }} 취소
                                    </x-button.filled.md-red>
                                </template>
                                <template x-if="data.load.data.phase === 3">
                                    <x-button.filled.md-blue class="w-full" type="button">
                                        설문 결과
                                    </x-button.filled.md-blue>
                                </template>
                            </div>
                        @endif

                    </div>
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
                                    url: '{{route('lounge.mission.read.refresh.api', $mission->id)}}',
                                    body: {},
                                    data: {
                                        phase: {{ $mission->phase }},
                                        status: '{{ $mission->getPhaseName() }}',
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
                                    },
                                },
                                participants: {
                                    url: '{{route('lounge.mission.read.participants.api', $mission->id)}}',
                                    body: {},
                                    data: {
                                        participants: []
                                    },
                                },
                                remove: {
                                    url: '{{route('lounge.mission.delete.api', $mission->id)}}',
                                    body: {},
                                    lock: false
                                },
                                process: {
                                    url: '{{route('lounge.mission.read.process.api', $mission->id)}}',
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
                                            if (r.data.data !== null) {
                                                if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                                    location.href = '{{route('lounge.mission.list')}}';
                                                }
                                            }
                                        }
                                        let error = (e) => {
                                            if (typeof e.response !== 'undefined' && e.response.status === 415) {
                                                //CSRF 토큰 오류 발생
                                                window.modal.alert('처리 실패', '로그인 정보를 확인할 수 없습니다.', (c) => {
                                                    Location.reload();
                                                }, 'error');
                                                return;
                                            }

                                            if (e.response.status === 422) {
                                                if (e.response.data.data.description === 'MISSION STATUS DOES\'T MATCH THE CONDITIONS') {
                                                    window.modal.alert('처리 실패', '해당 미션이 시작 처리되어 삭제할 수 없습니다.', (c) => {}, 'error');
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
                                    window.modal.alert('처리 완료', '성공적으로 처리하였습니다.', (c) => {});
                                };

                                let error = (e) => {
                                    if (typeof e.response !== 'undefined' && e.response.status === 415) {
                                        //CSRF 토큰 오류 발생
                                        window.modal.alert('처리 실패', '로그인 정보를 확인할 수 없습니다.', (c) => {
                                            Location.reload();
                                        }, 'error');
                                        return;
                                    }

                                    if (e.response.status === 422) {
                                        if (e.response.data.data.description === 'MISSION STATUS DOES\'T MATCH THE CONDITIONS') {
                                            window.modal.alert('처리 실패', '이미 처리되었습니다.', (c) => {}, 'error');
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
                            load() {
                                let success = (r) => {
                                    if (r.data.data !== null) {
                                        if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                            this.data.load.data = r.data.data;
                                        }
                                    }
                                };

                                let error = (e) => {
                                    console.log(e);
                                };

                                let complete = () => {};

                                if (this.interval.load === -1) {
                                    this.interval.load = setInterval(() => {this.post(this.data.load.url, this.data.load.body, success, error, complete)}, 5000);
                                } else {
                                    this.post(this.data.load.url, this.data.load.body, success, error, complete);
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
                                    this.interval.participants = setInterval(() => {this.post(this.data.participants.url, this.data.participants.body, success, error, complete)}, 5000);
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
                </script>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
