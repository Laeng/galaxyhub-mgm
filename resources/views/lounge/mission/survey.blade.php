<x-sub-page website-name="MGM Lounge" title="{{ $type }} {{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center lg:px-48">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <div class="text-center my-4 lg:mt-0 lg:mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold">
                        {{ "{$type} {$title}" }}
                    </h1>
                    @if($hasUserSurvey)
                        <p>{{ $hasUserSurveyDate->format('Y년 m월 d일 H시 i분') }}에 참여해 주셨습니다.</p>
                    @endif
                </div>

                <div class="">
                    @if($hasUserSurvey)
                        <x-survey.form :survey="$survey" action="" :answer="$answer"/>
                        <div class="flex justify-center mt-4 space-x-2">
                            @if($canAttend && !$hasAttend)
                                <x-button.filled.md-blue type="button" onclick="location.href='{{ route('lounge.mission.attend', $id) }}'">
                                    출석하기
                                </x-button.filled.md-blue>
                            @endif

                            <x-button.filled.md-white type="button" onclick="location.href='{{ route('lounge.mission.read', $id) }}'">
                                돌아가기
                            </x-button.filled.md-white>
                        </div>
                    @else
                        <x-survey.form :survey="$survey" :action="route('lounge.mission.attend', $id)" submit-text="출석하기" back-link="{{ route('lounge.mission.read', $id) }}" />
                    @endif
                </div>

            </div>
        </div>
    </x-section.basic>
</x-sub-page>
