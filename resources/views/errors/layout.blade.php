<!DOCTYPE html>
<html lang="ko" xml:lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="developer" content="Laeng">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title>ERROR</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
@stack('css')

<!-- Scripts -->
    <script defer src="{{ mix('js/app.js') }}"></script>
    @stack('js')
</head>
<body class="bg-gray-100 dark:bg-gray-900 overflow-x-hidden">
<div class="font-sans text-gray-900 dark:text-gray-100 antialiased h-screen">
    <div class="relative h-full">
        <div class="h-full grid grid-cols-1" style="align-content:center">
            <div class="max-w-7xl mx-auto py-4 px-4">
                <div class="flex justify-center lg:justify-start">
                    <div class="text-center lg:text-left">
                        <h1 class="text-6xl lg:text-9xl font-bold lg:font-extrabold">@yield('code')</h1>
                        <h3 class="text-4xl lg:text-6xl font-bold lg:font-extrabold -mt-2 lg:mt-0">@yield('title')</h3>
                        <p class="mt-2 lg:pt-0">@yield('message')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

