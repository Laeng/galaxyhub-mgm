@unless ($breadcrumbs->isEmpty())
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
            @foreach ($breadcrumbs as $breadcrumb)
                @if($loop->first)
                    <li>
                        <div>
                            <a href="{{ $breadcrumb->url }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="flex-shrink-0 h-4 w-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor" aria-hidden="true">
                                    <path d="M575.8 255.5C575.8 273.5 560.8 287.6 543.8 287.6H511.8L512.5 447.7C512.5 450.5 512.3 453.1 512 455.8V472C512 494.1 494.1 512 472 512H456C454.9 512 453.8 511.1 452.7 511.9C451.3 511.1 449.9 512 448.5 512H392C369.9 512 352 494.1 352 472V384C352 366.3 337.7 352 320 352H256C238.3 352 224 366.3 224 384V472C224 494.1 206.1 512 184 512H128.1C126.6 512 125.1 511.9 123.6 511.8C122.4 511.9 121.2 512 120 512H104C81.91 512 64 494.1 64 472V360C64 359.1 64.03 358.1 64.09 357.2V287.6H32.05C14.02 287.6 0 273.5 0 255.5C0 246.5 3.004 238.5 10.01 231.5L266.4 8.016C273.4 1.002 281.4 0 288.4 0C295.4 0 303.4 2.004 309.5 7.014L564.8 231.5C572.8 238.5 576.9 246.5 575.8 255.5L575.8 255.5z"/>
                                </svg>
                                <span class="sr-only">{{ $breadcrumb->title }}</span>
                            </a>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            @if (!is_null($breadcrumb->url) && !$loop->last)
                                <a href="{{ $breadcrumb->url }}" class="ml-4 text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-500">{{ $breadcrumb->title }}</a>
                            @else
                                <span class="ml-4 text-sm font-bold text-indigo-500">{{ $breadcrumb->title }}</span>
                            @endif
                        </div>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endunless
