<x-theme.galaxyhub.sub-content title="가입 퀴즈" description="가입 퀴즈" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '가입 퀴즈')">
    <x-panel.galaxyhub.basics>
        <div x-data="quiz">
            <div class="border-b border-gray-300 dark:border-gray-800 -mt-2 sm:-mt-4 mb-4">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="data.ui.mode ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = true"> 퀴즈 조회 </button>
                    <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" :class="!data.ui.mode ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'" @click="data.ui.mode = false"> 퀴즈 수정 </button>
                </nav>
            </div>

            <div x-show="data.ui.mode">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold">퀴즈 조회</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">현재 등록된 가입 퀴즈입니다. 총 {{ count($quiz) }} 문제이며 이 중 5문제가 무작위로 선택되어 가입 신청자에게 제공됩니다.</p>
                </div>
                <div class="py-4 space-y-8">
                    @foreach($quiz as $item)
                        <fieldset>
                            <legend class="leading-6 font-medium text-gray-900 dark:text-gray-100 mb-0.5">{{ $loop->index + 1 }}. {!! $item['title'] !!}</legend>

                            @if(!is_null($item['content']) && $item['content'] !== '')
                                <div class="p-4 rounded-md bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-800 my-2">
                                    <div class="text-sm text-gray-700 dark:text-gray-200">
                                        {!! $item['content'] !!}
                                    </div>
                                </div>
                            @endif

                            <div class="flex flex-col space-y-1 mt-4">
                                @foreach($item['options'] as $option)
                                    <label class="inline-flex items-start">
                                        <input type="radio" class="rounded-full dark:bg-gray-900 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring focus:ring-offset-0 mt-1" disabled @if($option === $item['answer']) checked @endif>
                                        <span class="ml-2">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    @endforeach
                </div>
            </div>

            <div x-show="!data.ui.mode">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold">퀴즈 수정</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">현재 퀴즈 수정은 지원되지 않습니다. 디스코드 laeng#1990 으로 문의주십시오.</p>
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
