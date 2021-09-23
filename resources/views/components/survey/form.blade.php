<div class="{{ $class }}">
    <form action="{!! $action !!}" method="post">
        @csrf
        <div class="flex flex-col space-y-4">
            @foreach($survey->sections as $section)
                <x-survey.section.single :section="$section"/>
            @endforeach

            @foreach($survey->questions()->withoutSection()->get() as $question)
                <x-survey.question.single :question="$question"/>
            @endforeach
        </div>
        <div class="flex justify-center mt-4">
            <x-button.filled.md-blue>
                {{ $submitText }}
            </x-button.filled.md-blue>
        </div>
    </form>
</div>
