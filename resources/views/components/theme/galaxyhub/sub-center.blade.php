<x-theme.galaxyhub.sub :website-name="$websiteName" :title="$title" :description="$description" class="bg-gray-100 dark:bg-gray-900">
    <x-container.galaxyhub.single parent-class="" class="">
        <div class="w-full flex flex-col lg:flex-row">
            {{ $slot }}
        </div>
    </x-container.galaxyhub.single>
</x-theme.galaxyhub.sub>
