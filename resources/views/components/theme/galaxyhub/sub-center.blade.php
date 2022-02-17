<x-theme.galaxyhub.sub :website-name="$websiteName" :title="$title" :description="$description" class="bg-gray-100 dark:bg-gray-900">
    <x-container.galaxyhub.single align-content="{{ $alignContent }}">
        {{ $slot }}
    </x-container.galaxyhub.single>
</x-theme.galaxyhub.sub>
