<x-theme.galaxyhub.sub-content title="이용약관" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app', '이용약관')">
    <x-panel.galaxyhub.basics>
        <div class="prose dark:prose-invert max-w-none">
            @include('components.agreements.rules')
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
