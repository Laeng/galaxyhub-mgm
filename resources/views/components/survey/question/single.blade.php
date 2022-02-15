<div class="py-4">
    <x-dynamic-component :component="'survey.question.type.' . $type" :question="$question" :answer="$answer"/>
</div>
