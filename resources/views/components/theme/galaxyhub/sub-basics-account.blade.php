<x-theme.galaxyhub.sub-basics :title="$title" :description="$title">
    <div class="flex flex-col-reverse md:flex-row items-start">
        <aside class="md:basis-4/12 xl:basis-3/12 md:sticky md:top-[4.75rem] md:py-8 md:px-4 w-full">
            <div class="flex flex-col space-y-8">
                @if($isMember)
                    <div class="hidden md:grid grid-cols-1 place-items-center">
                        <img class="inline-block h-28 w-28 rounded-full" src="{{ $user->avatar }}" alt="">
                        <p class="font-bold text-2xl mt-2">{{ $user->name }}</p>
                        <p class="tabular-nums">Since {{ $user->agreed_at->format('Y.m.d') }}</p>

                        <div class="flex justify-center flex-wrap w-1/3 md:w-1/2 mt-2">
                            <!-- 약장 -->
                            <svg class="h-6 w-6 p-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path d="M384 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V96C448 60.65 419.3 32 384 32zM352 360c0 13.25-10.75 24-24 24s-24-10.75-24-24V226.2l-60.55 83.83c-9.031 12.5-29.88 12.5-38.91 0L144 226.2V360C144 373.3 133.3 384 120 384S96 373.3 96 360v-208c0-10.41 6.719-19.64 16.61-22.83c9.859-3.25 20.75 .3125 26.84 8.781L224 255l84.55-117.1c6.094-8.469 16.89-12.03 26.84-8.781C345.3 132.4 352 141.6 352 152V360z"/>
                            </svg>
                            <svg class="h-6 w-6 p-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path d="M384 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V96C448 60.65 419.3 32 384 32zM352 360c0 13.25-10.75 24-24 24s-24-10.75-24-24V226.2l-60.55 83.83c-9.031 12.5-29.88 12.5-38.91 0L144 226.2V360C144 373.3 133.3 384 120 384S96 373.3 96 360v-208c0-10.41 6.719-19.64 16.61-22.83c9.859-3.25 20.75 .3125 26.84 8.781L224 255l84.55-117.1c6.094-8.469 16.89-12.03 26.84-8.781C345.3 132.4 352 141.6 352 152V360z"/>
                            </svg>
                            <svg class="h-6 w-6 p-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path d="M384 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V96C448 60.65 419.3 32 384 32zM352 360c0 13.25-10.75 24-24 24s-24-10.75-24-24V226.2l-60.55 83.83c-9.031 12.5-29.88 12.5-38.91 0L144 226.2V360C144 373.3 133.3 384 120 384S96 373.3 96 360v-208c0-10.41 6.719-19.64 16.61-22.83c9.859-3.25 20.75 .3125 26.84 8.781L224 255l84.55-117.1c6.094-8.469 16.89-12.03 26.84-8.781C345.3 132.4 352 141.6 352 152V360z"/>
                            </svg>
                        </div>
                    </div>
                @else
                    <div class="mb-4 lg:myb-6 text-2xl lg:text-4xl font-bold">&nbsp;</div>
                @endif

                <nav aria-label="Sidebar">
                    <div class="space-y-1">
                        @foreach($menu as $k => $v)
                            <a href="{{ $v['url'] }}" class="@if($v['url'] === '#') bg-white @endif text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md" aria-current="page">
                                {!! $v['icon'] !!}
                                <span class="truncate">{{ $k }}</span>
                            </a>
                        @endforeach
                    </div>
                    <div class="mt-8">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="projects-headline">링크</h3>
                        <div class="mt-1 space-y-1" aria-labelledby="projects-headline">
                            <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                                <span class="truncate">MGM 회칙</span>
                            </a>

                            <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                                <span class="truncate">MGM 공지사항</span>
                            </a>

                            <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                                <span class="truncate">아르마 길잡이</span>
                            </a>

                            <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                                <span class="truncate">팀스피크 설치</span>
                            </a>
                        </div>
                    </div>
                </nav>

            </div>
        </aside>

        <div class="md:basis-8/12 xl:basis-9/12 md:top-[4.75rem] md:py-8 md:px-4 w-full">
            <h1 class="mb-4 lg:myb-6 text-2xl lg:text-4xl font-bold">{{ $title }}</h1>
            <div class="mt-4 lg:mt-6">
                {!! $slot !!}
            </div>
        </div>
    </div>
</x-theme.galaxyhub.sub-basics>

