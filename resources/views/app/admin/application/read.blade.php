<x-theme.galaxyhub.sub-content :title="$title" :description="$title" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin.application', $title)">
    <div class="grid md:grid-cols-5 lg:grid-cols-3 gap-4">
        <x-panel.galaxyhub.basics >
            <h2 class="text-xl lg:text-2xl font-bold">가입 신청서</h2>
            <x-survey.form :survey="$survey" :answer="$answer"/>
        </x-panel.galaxyhub.basics>
    </div>

</x-theme.galaxyhub.sub-content>
