<!DOCTYPE html>
<html lang="ko" xml:lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="developer" content="Laeng">

    <title>MGM Updater</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://cdn.galaxyhub.kr">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
@stack('css')

<!-- Scripts -->
    <script defer src="{{ mix('js/app.js') }}"></script>
    @stack('js')
</head>
<body oncontextmenu="return false" ondragstart="return false" onselectstart="return false" class=" h-screen flex flex-col bg-[#27272a] overflow-x-hidden font-sans antialiased cursor-default">
{{ $slot }}
</body>
</html>
