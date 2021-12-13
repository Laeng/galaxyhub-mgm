<x-sub-page website-name="MGM Lounge" title="{{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{$title}}</h1>

                <div class="grid md:grid-cols-5 lg:grid-cols-3 gap-4">
                    <div class="md:col-span-3 lg:col-span-2">
                        <div class="">
                            <p class="text-lg font-bold">가입 신청자 응답</p>
                            <x-survey.form :survey="$surveyForm" :action="''" :answer="$answer"/>
                        </div>
                    </div>

                    <div class="md:col-span-2 lg:col-span-1" x-data="application_detail">
                        <p class="text-lg font-bold">부가 정보</p>
                        <ul class="divide-y divide-gray-200">

                            <li class="py-4">
                                <div class="flex justify-between">
                                    <p class="text-sm font-medium text-gray-800">
                                        상태
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $status }}
                                    </p>
                                </div>
                            </li>

                            @if ($status !== '접수')
                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            담당자
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $assign['nickname'] }}
                                        </p>
                                    </div>
                                </li>
                            @endif

                            <li class="py-4">
                                <div class="flex justify-between">
                                    <p class="text-sm font-medium text-gray-800">
                                        신청 날짜
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::instance(new DateTime($applications[0]['created_at']))->format('Y.m.d h:i') }}
                                    </p>
                                </div>
                            </li>

                            @if ($status !== '접수')
                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            처리 날짜
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::instance(new DateTime($assign['created_at']))->format('Y.m.d h:i') }}
                                        </p>
                                    </div>
                                </li>

                                <li class="py-4">
                                    <p class="text-sm font-medium text-gray-800 pb-2">
                                        사유
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $assign['reason'] }}
                                    </p>
                                </li>
                            @endif

                            <li class="py-4">
                                <div class="flex justify-between">
                                    <p class="text-sm font-medium text-gray-800">
                                        아르마3 플레이
                                    </p>
                                    <p class="text-sm text-gray-600" x-text="data.load.data.arma.playtimeForeverReadable"></p>
                                </div>
                            </li>

                            <li class="py-4">
                                <div class="flex justify-between">
                                    <p class="text-sm font-medium text-gray-800">
                                        차단 기록
                                    </p>
                                    <p class="text-sm text-gray-600" x-text="'VAC ' + data.load.data.ban.NumberOfVACBans + '회 / 게임 ' + data.load.data.ban.NumberOfGameBans + '회'"></p>
                                </div>
                            </li>

                            <li class="py-4">
                                <div class="flex justify-between">
                                    <p class="text-sm font-medium text-gray-800">
                                        구입한 게임
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <a href="{{ route('staff.user.application.detail.games', [$user->id]) }}" target="_blank">확인하기</a>
                                    </p>
                                </div>
                            </li>

                            <li class="py-4">
                                <template x-if="data.load.data.group.groupID64 === ''">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            가입한 클랜
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            없음
                                        </p>
                                    </div>
                                </template>
                                <template x-if="data.load.data.group.groupID64 !== ''">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800 pb-2">
                                            가입한 클랜 - <a class="text-blue-500 hover:text-blue-800" :href="'https://steamcommunity.com/profiles/' +  data.load.data.summaries.steamId + '/groups/'" target="_blank">더보기</a>
                                        </p>
                                        <a :href="'https://steamcommunity.com/gid/' + data.load.data.group.groupID64" target="_blank">
                                            <div class="flex">
                                                <div class="mr-4 flex-shrink-0">
                                                    <div class="h-16 w-16" x-html="data.load.data.group.groupDetails.avatarFull"></div>
                                                </div>
                                                <div>
                                                    <p class="-mt-1 text-sm font-medium" x-text="data.load.data.group.groupDetails.name"></p>
                                                    <p class="text-sm text-gray-600" x-text="data.load.data.group.groupDetails.summary.replace(/(<([^>]+)>)/ig,'')"></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </template>
                            </li>

                        </ul>

                        <div class="grid gap-2 py-4">
                            <template x-if="data.load.data.summaries.steamId !== ''">
                                <x-button.filled.md-white @click="window.open('https://steamcommunity.com/profiles/' + data.load.data.summaries.steamId)" type="button">
                                    STEAM 프로필 보기
                                </x-button.filled.md-white>
                            </template>
                            <template x-if="data.load.data.summaries.steamId !== ''">
                                <x-button.filled.md-white @click="window.open('https://steamcommunity.com/profiles/' + data.load.data.summaries.steamId + '/friends')" type="button">
                                    STEAM 친구 목록 보기
                                </x-button.filled.md-white>
                            </template>
                            <template x-if="data.load.data.naver_id !== ''">
                                <x-button.filled.md-white @click="window.open('https://cafe.naver.com/ca-fe/cafes/17091584/members?memberId=' + data.load.data.naver_id)" type="button">
                                    네이버 카페 활동 보기
                                </x-button.filled.md-white>
                            </template>
                        </div>

                        <div class="py-4">
                            <p class="text-lg font-bold pb-4">유저 기록</p>
                            <x-memo.simple user-id="{{$user->id}}"/>
                        </div>

                        <div class="grid grid-cols-3 gap-2 py-4">
                            @if ($status === '접수')
                                <x-button.filled.md-white @click="process('accept', '가입 승인', '가입을 승인 하시겠습니까?', false)" type="button">
                                    승인
                                </x-button.filled.md-white>
                                <x-button.filled.md-white @click="process('reject', '가입 거절', '거절 사유를 입력해 주십시오.')" type="button">
                                    거절
                                </x-button.filled.md-white>
                                <x-button.filled.md-white @click="process('defer', '가입 보류', '보류 사유를 입력해 주십시오.')" type="button">
                                    보류
                                </x-button.filled.md-white>
                            @endif
                            <x-button.filled.md-white onClick="location.href='{{ back()->getTargetUrl() }}'" type="button" class="col-span-3">
                                돌아가기
                            </x-button.filled.md-white>
                        </div>

                        <script type="text/javascript">
                            window.document.addEventListener('alpine:init', () => {
                                window.alpine.data('application_detail', () => ({
                                    interval: {
                                        load: -1
                                    },
                                    data: {
                                        process: {
                                            url: '{{ route('staff.user.api.application.process') }}',
                                            lock: false
                                        },
                                        load: {
                                            url: '{{ route('staff.user.api.application.detail.info', [$user->id]) }}',
                                            body: {
                                                user_id: '{{ $user->id }}'
                                            },
                                            data: {
                                                summaries: {
                                                    steamId: ''
                                                },
                                                arma: {
                                                    playtimeForeverReadable: '불러오는 중'
                                                },
                                                ban: {
                                                    NumberOfVACBans: 0,
                                                    NumberOfGameBans: 0
                                                },
                                                group: {
                                                    groupDetails: {
                                                        avatarFull: '',
                                                        summary: ''
                                                    },
                                                    groupID64: ''
                                                },
                                                naver_id: ''
                                            }
                                        }
                                    },
                                    @if($status === '접수')
                                    process(type, title, message, prompt = true) {
                                        let callback = (r) => {
                                            if (r.isConfirmed) {
                                                let body = {
                                                    type: type,
                                                    user_id: ["{{ $user->id }}"],
                                                    reason: (prompt) ? r.value : null
                                                };

                                                let success = (r) => {
                                                    window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {
                                                        location.href = '{{ route('staff.user.application') }}';
                                                    });
                                                };

                                                let error = (e) => {
                                                    window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                                                    console.log(e);
                                                };

                                                let complete = () => {
                                                    this.data.process.lock = false;
                                                };

                                                if (!this.data.process.lock) {
                                                    this.data.process.lock = true;
                                                    this.post(this.data.process.url, body, success, error, complete);
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
                                                    this.data.load.data.summaries = r.data.data.summaries;
                                                    this.data.load.data.arma = r.data.data.arma;
                                                    this.data.load.data.ban = r.data.data.ban;
                                                    this.data.load.data.naver_id = r.data.data.naver_id;

                                                    if (r.data.data.group != null) {
                                                        this.data.load.data.group = r.data.data.group;
                                                    }

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
                                            this.interval.load = setInterval(() => {this.post(this.data.load.url, this.data.load.body, success, error, complete)}, 5000);
                                        }
                                    },
                                    init() {
                                        this.load();
                                    },
                                    post(url, body, success, error, complete) {
                                        window.axios.post(url, body).then(success).catch(error).then(complete);
                                    }
                                }));
                            });
                        </script>
                    </div>
                </div>

            </div>
        </div>
    </x-section.basic>
</x-sub-page>
