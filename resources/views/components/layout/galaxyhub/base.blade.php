<!DOCTYPE html>
<html lang="ko" xml:lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description }}">
    <meta name="developer" content="Laeng">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title === '' ? $websiteName : $title }}" />
    <meta property="og:description" content="{{ $description }}" />
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $websiteName }}">
    <meta property="og:image" content="{{ asset('images/og_image.png') }}">
    <meta property="og:locale" content="ko_KR">

    <title>{{ $title == '' ? $websiteName : "{$title} - {$websiteName}" }}</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://cdn.galaxyhub.kr">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('css')

<!-- Scripts -->
    <script defer src="{{ mix('js/app.js') }}"></script>
    @stack('js')
</head>
<body class="bg-gray-900 overflow-x-hidden">
<div class="font-sans text-gray-900 dark:text-gray-100 antialiased {{ $class }}" {{$attributes}}>
    {{ $slot }}
</div>
@stack('script')
@php
    $hasErrors = !empty($errors);
    $errorMessages = ($hasErrors) ? $errors->getMessages() : [];
@endphp
@if($hasErrors && (array_key_exists('error', $errorMessages) || array_key_exists('success', $errorMessages)))
    <script type="text/javascript">
        window.addEventListener('load', function(){
            @foreach($errorMessages as $k => $v)
            @foreach($v as $vv)
            window.modal.alert('', '{{ $vv }}', c => {}, '{{ $k }}');
            //window.toast.show('{{ $k }}', '{{ $vv }}', {{ $k == 'error' ? -1 : 3000 }});
            @endforeach
            @endforeach
        });
    </script>
@endif
<noscript>
    <div class="block-overlay">
        <div style="font-size: 18pt; text-align: center">
            <h1 style="display:block;">본 웹사이트는 자바스크립트(JavaScript) 를 사용합니다.</h1>
            <h1 style="display:block;">자바스크립트(JavaScript) 를 활성화하여 주십시오.</h1>
        </div>
    </div>
</noscript>
</body>
</html>
