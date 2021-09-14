<!DOCTYPE html>
<html lang="ko" xml:lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <meta name="description" content="최고의 아르마3 클랜, 멀티플레이 게임 매니지먼트의 웹사이트 입니다. #아르마3 #스타시티즌 #MGM">
    <meta name="developer" content="Laeng">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Multiplay Game Management">
    <meta property="og:image" content="{{ asset('images/og_image.png') }}">
    <meta property="og:locale" content="ko_KR">
    @stack('og')

    <title>{{ $title ?? "Multiplay Game Management" }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script defer src="{{ mix('js/app.js') }}"></script>
</head>
<body class="bg-gray-900 overflow-x-hidden">
<div class="font-sans text-gray-900 antialiased {{ $class }}" {{$attributes}}>
    {{ $slot }}
</div>
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
