<x-theme.galaxyhub.sub-content title="가입 신청서" description="가입 신청서" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '가입 신청서')">
    <x-panel.galaxyhub.basics>
        <div x-data="quiz">
            <div class="border-b border-gray-300 dark:border-gray-800 -mt-2 sm:-mt-4 mb-4">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="data.ui.mode ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = true"> 신청서 조회 </button>
                    <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="!data.ui.mode ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = false"> 신청서 수정 </button>
                </nav>
            </div>

            <div x-show="data.ui.mode">
                <div class="space-y-8">
                    <div>
                        @foreach($form as $item)
                            @switch($item['type'])
                                @case('section')
                                <div>
                                    <p class="text-xl lg:text-2xl font-bold mb-1">{!! $item['contents']['name'] !!}</p>
                                    <div class="flex flex-col space-y-2 mb-2">{!! $item['contents']['description'] !!}</div>
                                </div>
                                @break
                                @case('question')
                                @foreach($item['contents'] as $question)
                                    <div class="py-4">
                                        <label class="block">
                                            <p class="leading-6 font-medium text-gray-900 dark:text-gray-100 mb-0.5">{!! $question['title'] !!}</p>

                                            @if(!is_null($question['content']) && $question['content'] !== '')
                                                <p class="text-sm text-gray-500 dark:text-gray-300 mb-2">{!! $question['content'] !!}</p>
                                            @endif

                                            @php
                                                if (empty($question['type'])) $question['type'] = 'text';
                                            @endphp

                                            @switch($question['type'])
                                                @case('radio')
                                                <div class="flex flex-col lg:flex-row space-y-2 lg:space-y-0 lg:space-x-4">
                                                    @foreach($question['options'] as $option)
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" class="rounded-full dark:bg-gray-900 border-gray-300 dark:border-gray-800 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring focus:ring-offset-0" disabled>
                                                            <span class="ml-2">{{ $option }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @break
                                                @case('image')
                                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                                    <div class="space-y-1 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <div class="flex text-sm text-gray-600">
                                                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                                <span>Upload a file</span>
                                                            </label>
                                                            <p class="pl-1">or drag and drop</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case('long-text')
                                                <textarea rows="3" class="block w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-800 focus:ring-blue-500 shadow-sm" disabled></textarea>
                                                @break
                                                @case('date')
                                                <input type="date" class="block w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-800 shadow-sm focus:ring-blue-500" disabled>
                                                @break
                                                @default
                                                <input type="text" class="block w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-800 shadow-sm focus:ring-blue-500" disabled>
                                                @break
                                            @endswitch
                                        </label>
                                    </div>
                                @endforeach
                                @break
                            @endswitch
                        @endforeach
                    </div>
                </div>
            </div>

            <div x-show="!data.ui.mode">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold">신청서 수정</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">신청서 수정은 지원되지 않습니다. 디스코드 laeng#1990 으로 문의주십시오.</p>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            document.addEventListener('alpine:init', () => {
                window.alpine.data('quiz', () => ({
                    data: {
                        ui: {
                            mode: true
                        },
                    }
                }));
            });
        </script>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
