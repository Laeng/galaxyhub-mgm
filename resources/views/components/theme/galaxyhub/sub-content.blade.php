<x-theme.galaxyhub.sub :website-name="$websiteName" :title="$title" :description="$description" class="bg-gray-100 dark:bg-gray-900">
    <x-container.galaxyhub.basics parent-class="py-4 sm:py-6 lg:mb-4 xl:mb-8" class="">
        <div class="my-2 lg:my-6 text-sm font-bold text-gray-400">
            {!! $breadcrumbs !!}
        </div>
        <div>
            <h1 class="my-4 lg:my-6 text-2xl lg:text-4xl font-bold">{{ $title }}</h1>
            <div class="mt-4 lg:mt-6">
                {!! $slot !!}
            </div>
        </div>
    </x-container.galaxyhub.basics>
</x-theme.galaxyhub.sub>
