@push('og')
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $description }}" />
@endpush

<x-layout.layout class="flex flex-col h-screen" title="{{ $title }} - 멀티플레이 게임 매니지먼트">
    <x-layout.header parent-class="bg-gray-900 w-full" logo-hex-code="text-[#ffffff]" logo-text-class="text-white" menu-text-class="text-gray-200 lg:text-sm"/>

    <div class="flex-grow mt-[3.75rem] bg-gray-100">
        {{ $slot }}
    </div>

    <x-layout.footer/>
</x-layout.layout>
