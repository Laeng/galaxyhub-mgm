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
                                @if($isMaker)
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
                                <div class="mission-body prose max-w-full">
                                    {!! $mission->body !!}
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <p class="text-lg font-bold mb-2">{{ $type }} 참가자</p>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="relative rounded-lg border border-gray-200 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-40">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="#" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-gray-900">
                                                Leslie
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                10회 참가
                                            </p>
                                        </a>
                                    </div>
                                </div>

                                <div class="relative rounded-lg border border-gray-200 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-40">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="#" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-gray-900">
                                                Leslie
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                10회 참가
                                            </p>
                                        </a>
                                    </div>
                                </div>

                                <div class="relative rounded-lg border border-gray-200 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-40">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="#" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-gray-900">
                                                Leslie
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                10회 참가
                                            </p>
                                        </a>
                                    </div>
                                </div>

                                <div class="relative rounded-lg border border-gray-200 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-40">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="#" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-gray-900">
                                                Leslie
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                10회 참가
                                            </p>
                                        </a>
                                    </div>
                                </div>

                                <div class="relative rounded-lg border border-gray-200 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-40">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        <p class="text-sm font-medium text-gray-900">
                                            Leslie
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            미션 10회 참가
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2 lg:col-span-1">
                        <p class="text-lg font-bold mb-2">{{ $type }} 시간</p>
                        <div class="mb-3">
                            <div class="p-4 bg-gray-50 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    {{ $mission->expected_at->format('Y년 m월 d일') }}
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    {{ $mission->expected_at->format('h시 m분') }}
                                </dd>
                            </div>
                        </div>
                        <!--
                        <p class="text-lg font-bold mb-2">{{ $type }} 출석 마감</p>
                        <div class="mb-3">
                            <div class="p-4 bg-gray-50 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    @if(!is_null($mission->ended_at)){{ $mission->ended_at->copy()->addHours(12)->format('Y년 m월 d일') }}@endif
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    @if(!is_null($mission->ended_at)){{ $mission->ended_at->copy()->addHours(12)->format('h시 m분') }}@endif
                                </dd>
                            </div>
                        </div>
                        -->

                        @if ($isMaker)
                            <p class="text-lg font-bold mb-2">{{ $type }} 출석 코드</p>
                            <div class="mb-3">
                                <div class="p-4 bg-gray-50 rounded-lg overflow-hidden">
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        @if($mission->phase < 2) {{ $type }} 종료 후 발급됩니다. @else 4자리 숫자 @endif
                                    </dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900 @if($mission->phase < 2) blur @endif">
                                        @if($mission->phase < 2) XXXX @else {{ $missiom->code }} @endif
                                    </dd>
                                </div>
                            </div>
                        @endif

                        <div class="mb-6 space-y-2">
                            @if($isMaker)
                                <template x-if='data.phase === 0'>
                                    <x-button.filled.md-white class="w-full" type="button" onclick="location.href='{{ route('lounge.mission.update', $id) }}'" x-cloak>
                                        {{ $type }} 수정
                                    </x-button.filled.md-white>
                                </template>
                                <template x-if='data.phase === 0'>
                                    <x-button.filled.md-white class="w-full" type="button" x-cloak>
                                        {{ $type }} 시작
                                    </x-button.filled.md-white>
                                </template>
                                <template x-if='data.phase === 1'>
                                    <x-button.filled.md-white class="w-full" type="button" x-cloak>
                                        {{ $type }} 종료
                                    </x-button.filled.md-white>
                                </template>
                            @else
                                <x-button.filled.md-blue class="w-full" type="button">
                                    출석 체크
                                </x-button.filled.md-blue>
                                <x-button.filled.md-blue class="w-full" type="button">
                                    참가 신청
                                </x-button.filled.md-blue>
                                <x-button.filled.md-blue class="w-full" type="button">
                                    참가 취소
                                </x-button.filled.md-blue>
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
                                            상태
                                        </p>
                                        <p class="text-sm text-gray-600" x-text="data.status"></p>
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
                                        <p class="text-sm text-gray-600">
                                            {{ $mission->created_at->format('Y-m-d H:i') }}
                                        </p>
                                    </div>
                                </li>

                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            미션 시작
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            @if(!is_null($mission->started_at)){{ $mission->started_at->format('Y-m-d H:i') }}@endif
                                        </p>
                                    </div>
                                </li>

                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            미션 종료
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            @if(!is_null($mission->ended_at)){{ $mission->ended_at->format('Y-m-d H:i') }}@endif
                                        </p>
                                    </div>
                                </li>

                                <li class="py-4">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-800">
                                            출석 마감
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            @if(!is_null($mission->ended_at)){{ $mission->ended_at->copy()->addHours(12)->format('Y-m-d H:i') }}@endif
                                        </p>
                                    </div>
                                </li>

                            </ul>
                        </div>

                        @if($isMaker)
                            <div class="space-y-2">
                                <template x-if="data.phase === 0">
                                    <x-button.filled.md-red class="w-full" type="button" @click="remove()">
                                        {{ $type }} 삭제
                                    </x-button.filled.md-red>
                                </template>
                                <template x-if="data.phase === 1">
                                    <x-button.filled.md-red class="w-full" type="button">
                                        {{ $type }} 취소
                                    </x-button.filled.md-red>
                                </template>
                                <template x-if="data.phase === 3">
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
                            interval: {},
                            data: {
                                id: {{$mission->id}},
                                phase: {{ $mission->phase }},
                                status: '{{ $mission->getPhaseName() }}',
                                view: {
                                    participant: {

                                    },
                                    maker: {

                                    },
                                },
                                remove: {
                                    url: '{{route('lounge.mission.delete.api', $id)}}',
                                    body: {}
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
                                            if (e.response.status === 415) {
                                                //CSRF 토큰 오류 발생
                                                window.modal.alert('처리 실패', '로그인 정보를 확인할 수 없습니다.', (c) => {
                                                    Location.reload();
                                                }, 'error');
                                                return;
                                            }

                                            if (e.response.status === 422) {
                                                if (e.response.data.data.description === 'CAN NOT DELETE MISSION BECAUSE MISSION STATUS IS NOT READY') {
                                                    window.modal.alert('처리 실패', '해당 미션이 시작 처리되어 삭제할 수 없습니다.', (c) => {}, 'error');
                                                }
                                            }
                                            window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                                            console.log(e);
                                        }
                                        let complete = () => {}

                                        this.post(this.data.remove.url, this.data.remove.body, success, error, complete);
                                    }
                                });
                            },
                            init() {

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
