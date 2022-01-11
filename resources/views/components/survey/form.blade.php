<div class="{{ $class }}">
    <form action="{!! $action !!}" method="post">
        @csrf
        <div class="flex flex-col space-y-4">
            @foreach($survey->sections as $section)
                <x-survey.section.single :section="$section" :answer="$answer"/>
            @endforeach

            @foreach($survey->questions()->withoutSection()->get() as $question)
                <x-survey.question.single :question="$question" :answer="$answer"/>
            @endforeach
        </div>
        @if(is_null($answer))
            <div class="flex justify-center mt-4 space-x-2">
                <x-button.filled.md-blue type="submit">
                    {{ $submitText }}
                </x-button.filled.md-blue>

                <x-button.filled.md-white type="button" onclick="location.href='{{ back()->getTargetUrl() }}'">
                    돌아가기
                </x-button.filled.md-white>
            </div>
        @endif
    </form>
</div>
