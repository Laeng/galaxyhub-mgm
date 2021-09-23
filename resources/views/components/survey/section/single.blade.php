<div class="mb-2">
    <p class="text-xl font-bold mb-1">{!! $section->name !!}</p>
    <div class="flex flex-col space-y-2 mb-2">{!! $section->description !!}</div>
    @foreach($section->questions as $question)
        <x-survey.question.single :question="$question" />
    @endforeach
</div>
