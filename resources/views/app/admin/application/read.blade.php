<x-theme.galaxyhub.sub-content :title="$title" :description="$title" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin.application', $applicant->name)">
    <div class="grid md:grid-cols-5 lg:grid-cols-3 gap-4">
        <x-panel.galaxyhub.basics class="md:col-span-3 lg:col-span-2">
            <h2 class="text-xl lg:text-2xl font-bold">가입 신청서</h2>
            <x-survey.form :survey="$survey" :answer="$answer"/>
        </x-panel.galaxyhub.basics>

        <div class="md:col-span-3 lg:col-span-2">
            <h2 class="text-xl lg:text-2xl font-bold">부가 정보</h2>
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
                            접수 날짜
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ $application->created_at->format('Y-m-d h:i') }}
                        </p>
                    </div>
                </li>

                @if ($status !== '가입 신청')
                    <li class="py-4">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-800">
                                처리 날짜
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::instance(new DateTime($assign['created_at']))->format('Y-m-d h:i') }}
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
                            <a href="{{ route('staff.user.application.read.games', [$user->id]) }}" target="_blank">확인하기</a>
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
                @if ($status === '가입 신청')
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
        </div>
    </div>

</x-theme.galaxyhub.sub-content>
