<x-theme.galaxyhub.sub-content title="개인정보처리방침" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app', '개인정보처리방침')">
    <x-panel.galaxyhub.basics>
        <div class="prose dark:prose-invert max-w-none">
            @include('components.agreements.privacy')
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
