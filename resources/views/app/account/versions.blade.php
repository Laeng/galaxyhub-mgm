<x-theme.galaxyhub.sub-basics-account :title="$title" :user="$user">
    <x-panel.galaxyhub.basics>
        <div class="">
            <div>
                <h2 class="text-xl lg:text-2xl font-bold">버전 정보</h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">MGM Lounge 버전 정보 입니다.</p>
            </div>
            <div class="mt-5 border-t border-gray-300 dark:border-gray-800">
                <dl class="sm:divide-y sm:divide-gray-300 sm:dark:divide-gray-800">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">버전</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $commitHash }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">날짜</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $commitDate }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">제작</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">Laeng</dd>
                    </div>
                </dl>
            </div>
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-basics-account>
