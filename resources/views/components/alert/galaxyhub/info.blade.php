<div class="rounded-md bg-blue-50 dark:bg-gray-900 dark:border dark:border-blue-500 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor" d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM296 336h-16V248C280 234.8 269.3 224 256 224H224C210.8 224 200 234.8 200 248S210.8 272 224 272h8v64h-16C202.8 336 192 346.8 192 360S202.8 384 216 384h80c13.25 0 24-10.75 24-24S309.3 336 296 336zM256 192c17.67 0 32-14.33 32-32c0-17.67-14.33-32-32-32S224 142.3 224 160C224 177.7 238.3 192 256 192z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-bold text-blue-800 dark:text-blue-200">{{ $title }}</h3>
            <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                {!! $slot !!}
            </div>
        </div>
    </div>
</div>
