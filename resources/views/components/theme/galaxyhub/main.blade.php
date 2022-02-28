<x-layout.galaxyhub.base class="flex flex-col h-screen" :website-name="$websiteName" :title="$title" :description="$description">
    <x-layout.galaxyhub.header
        parent-class="bg-gray-900 w-full shadow-lg dark:shadow-xl"
        logo-hex-code="text-white"
        logo-text-class="text-white hover:text-pink-500"
        menu-text-class="text-gray-200 lg:text-sm"
        website-name="{{$websiteName}}"
    />

    <div class="grow mt-[3.75rem] {{ $class }}">
        {{ $slot }}
    </div>

    <x-layout.galaxyhub.footer/>
</x-layout.galaxyhub.base>
