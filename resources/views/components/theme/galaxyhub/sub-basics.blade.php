<x-theme.galaxyhub.sub :website-name="$websiteName" :title="$title" :description="$description" class="bg-gray-100 dark:bg-gray-900">
    <x-container.galaxyhub.basics>
        {{ $slot }}
    </x-container.galaxyhub.basics>
</x-theme.galaxyhub.sub>
