<x-theme.galaxyhub.sub-content title="개인정보처리방침" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app', '개인정보처리방침')">
    <x-panel.galaxyhub.basics>
        <div class="prose dark:prose-invert max-w-none">
            @include($path)
        </div>
        <div class="mt-16">
            <h1 class="font-bold text-xl my-4">이전 개인정보약관</h1>
            <div class="overflow-hidden ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-500">
                    <tbody>
                    <tr>
                        <td class="whitespace-nowrap p-4 text-sm">v1.0</td>
                        <td class="whitespace-nowrap p-4 text-sm w-full">2022.03.01</td>
                        <td class="whitespace-nowrap p-4 text-sm link-indigo"><a href="{{ route('app.privacy.date', 220301) }}">바로가기</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
