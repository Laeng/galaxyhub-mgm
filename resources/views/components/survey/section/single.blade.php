<div class="mb-2">
    @if (is_null($answer))
        <p class="text-xl font-bold mb-1">{!! $section->name !!}</p>
        <div class="flex flex-col space-y-2 mb-2">{!! $section->description !!}</div>
    @endif
    @foreach($section->questions as $question)
        <x-survey.question.single :question="$question" :answer="$answer"/>
    @endforeach
</div>
