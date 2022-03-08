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
                            @foreach($badges as $item)
                                <img class="h-6 w-6 p-0.5" alt="{{ $item->badge->name }}" src="{{ asset($item->badge->icon) }}" >
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mb-4 lg:myb-6 text-2xl lg:text-4xl font-bold">&nbsp;</div>
                @endif

                <nav aria-label="Sidebar">
                    <div class="space-y-1">
                        @foreach($menu as $k => $v)
                            <a href="{{ $v['url'] }}" class="@if($v['url'] === '#') bg-white dark:bg-[#080C15]/50 @else hover:bg-gray-50 dark:hover:bg-[#080C15]/50 @endif text-gray-900 dark:text-gray-100 group flex items-center px-3 py-2 text-sm font-medium rounded-md space-x-2" aria-current="page">
                                {!! $v['icon'] !!}
                                <span class="truncate">{{ $k }}</span>
                            </a>
                        @endforeach
                    </div>
                    <div class="mt-8">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="projects-headline">링크</h3>
                        <div class="mt-1 space-y-1" aria-labelledby="projects-headline">
                            <a href="https://cafe.naver.com/gamemmakers/book5086642/37323" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-md hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-[#080C15]/50 ">
                                <span class="truncate">MGM 회칙</span>
                            </a>

                            <a href="https://cafe.naver.com/gamemmakers/menu/1" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-md hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-[#080C15]/50 ">
                                <span class="truncate">MGM 공지사항</span>
                            </a>

                            <a href="https://cafe.naver.com/gamemmakers/book5076085" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-md hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-[#080C15]/50 ">
                                <span class="truncate">아르마 길잡이</span>
                            </a>

                            <a href="https://cafe.naver.com/gamemmakers/book5076085/23127" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-md hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-[#080C15]/50 ">
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

