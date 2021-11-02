@push('og')
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $description }}" />
@endpush

<x-layout.layout class="flex flex-col h-screen" title="{{ $title }} - {{$websiteName}}">
    <x-layout.header parent-class="bg-gray-900 w-full" logo-hex-code="text-[#ffffff]" logo-text-class="text-white hover:text-pink-500" menu-text-class="text-gray-200 lg:text-sm" website-name="{{$websiteName}}"/>

    <div class="flex-grow mt-[3.75rem] bg-gray-100">
        {{ $slot }}
    </div>

    <x-layout.footer/>
</x-layout.layout>

@if($errors->has('error') || $errors->has('success'))
    <script type="text/javascript">
    @foreach($errors->getMessages() as $name => $messages)
        @foreach($messages as $message)
            window.toast.show('{{ $name }}', '{{ $message }}', {{ $name == 'error' ? -1 : 3000 }});
        @endforeach
    @endforeach
    </script>
@endif
