<x-theme.galaxyhub.sub-content title="만족도 조사" description="만족도 조사" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.mission', '만족도 조사')">
    <x-panel.galaxyhub.basics>
        @if($isParticipate)
            <div>
                <h2 class="text-xl lg:text-2xl font-bold">참여 완료</h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">{{ $user->name }}님께서는 만족도 조사를 {{ $participateDate }}에 참여하셨습니다.</p>
            </div>
            <div class="flex flex-col space-y-4">
                <x-survey.form :survey="$survey" action="" :answer="$answer"/>
                <div class="flex justify-center mt-4 space-x-2">
                    @if($canAttend && !$hasAttend)
                        <x-button.filled.md-blue type="button" onclick="location.href='{{ route('mission.read.attend', $mission->id) }}'">
                            출석하기
                        </x-button.filled.md-blue>
                    @endif

                    <x-button.filled.md-white type="button" onclick="location.href='{{ route('mission.read', $mission->id) }}'">
                        돌아가기
                    </x-button.filled.md-white>
                </div>
            </div>
        @else
            <div class="flex flex-col space-y-4">
                <x-alert.galaxyhub.info title="도와주세요!">
                    <ul>
                        <li>더 즐거운 미션을 만들기 위해 만족도 조사를 진행하고 있습니다.</li>
                        <li>이번 {{ $missionType }}에 대하여 {{ $user->name }}님의 소중한 의견을 듣고자 합니다. 참여해 주시면 감사드립니다.</li>
                    </ul>
                </x-alert.galaxyhub.info>
                <x-survey.form :survey="$survey" submit-text="출석하기" action="{{ route('mission.read.attend', $mission->id) }}"/>
            </div>
        @endif
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
