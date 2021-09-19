@push('og')
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $description }}" />
@endpush

<x-layout.layout class="flex flex-col h-screen" title="{{ $title }} - {{$websiteName}}">
    <x-layout.header parent-class="bg-gray-900 w-full" logo-hex-code="text-[#ffffff]" logo-text-class="text-white" menu-text-class="text-gray-200 lg:text-sm" website-name="{{$websiteName}}"/>

    <div class="flex-grow mt-[3.75rem] bg-gray-100">
        {{ $slot }}
    </div>

    <x-layout.footer/>
</x-layout.layout>
