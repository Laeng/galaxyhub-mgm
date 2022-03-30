@push('js')
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
@endpush

<x-theme.galaxyhub.sub-content title="만족도 조사 결과" description="만족도 조사 결과" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.mission', '만족도 조사 결과')">
    <x-panel.galaxyhub.basics>
        <div class="md:pt-8">
            <div class="md:text-center">
                <h2 class="text-xl lg:text-2xl font-bold">{{ $missionType }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    {{ $mission->started_at->format('Y년 m월 d일 H시 m분') }}에 시작한 {{ $missionType }}에 대한 만족도 조사 결과입니다.<br class="hidden md:block"/>
                    회원 1명이 본 만족도 조사에 참가해주셨습니다. 만약 주관식 문항의 답변 중에 폭언이나 욕설을 발견하셨다면 스탭에게 알려주십시오.
                </p>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-8">
            @foreach($data as $datum)
                <div class="@if($datum['type'] !== 'radio') lg:col-span-2 @endif">
                    <div class="flex space-x-2">
                        @if($datum['type'] === 'radio')
                            <p class="h-6 w-14 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 justify-center">
                                객관식
                            </p>
                        @else
                            <p class="h-6 w-14 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 justify-center">
                                주관식
                            </p>
                        @endif
                        <p class="font-bold">{{ $datum['title'] }}</p>
                    </div>

                    @if($datum['type'] === 'radio')
                        <div class="py-4 flex justify-center">
                            <div class="mb-4">
                                <canvas id="{{ "question{$loop->index}" }}"></canvas>
                            </div>
                        </div>
                    @else
                        <div class="py-4">
                            <div class="mb-4">
                                @if($isAdmin)
                                    <x-alert.galaxyhub.danger title="주의">
                                        <ul>
                                            <li>주관식 문항 작성자는 관리자에게만 표시됩니다. 회원 정보가 노출 되지 않도록 주의하십시오.</li>
                                        </ul>
                                    </x-alert.galaxyhub.danger>
                                @endif
                                <ul class="divide-y divide-gray-200 pt-2">
                                    @if(count($datum['userAnswer']) > 0)
                                    @foreach($datum['userAnswer'] as $userAnswer)
                                        <li class="py-2">
                                            <div class="flex space-x-3">
                                                @if($isAdmin)
                                                    <a href="{{ route('admin.user.read', $userAnswer['user']->id) }}" target="_blank" class="link-indigo pb-1">{{ $userAnswer['user']->name }}</a>
                                                @endif
                                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $userAnswer['answer'] }}
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                    @else
                                        <li class="py-2 text-sm text-gray-900 dark:text-gray-100">본 문항에 응답한 회원이 없습니다.</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <script type="text/javascript">
            window.addEventListener('load', function(){
                let colors = [
                    '#22c55e',
                    '#84cc16',
                    '#eab308',
                    '#f97316',
                    '#ef4444'
                ]

                @foreach($data as $datum)
                @if ($datum['type'] == 'radio')
                new Chart('{{ "question{$loop->index}" }}', {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($datum['options']) !!},
                        datasets: [{label: '{{ $datum['title'] }}', data: {!! json_encode(array_values($datum['countOptions'])) !!}, backgroundColor: colors, hoverOffset: 2, borderWidth:1}],
                    },
                });
                @endif
                @endforeach
            });
        </script>

        <div class="flex justify-center mt-4 space-x-2">
            <x-button.filled.md-white type="button" onclick="location.href='{{ route('mission.read', $mission->id) }}'">
                돌아가기
            </x-button.filled.md-white>
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
