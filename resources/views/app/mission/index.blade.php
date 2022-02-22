<x-theme.galaxyhub.sub-content title="미션" description="아르마3 미션 목록" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app', '미션')">
    <x-panel.galaxyhub.basics>

        <div class="flex flex-col space-y-2">
            @foreach($messages as $message)
                <x-dynamic-component :component="'alert.' .$message[0]" :title="$message[1]">
                    {!! $message[2] !!}
                </x-dynamic-component>
            @endforeach
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
