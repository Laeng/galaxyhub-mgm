@push('js')
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
@endpush

<x-sub-page website-name="MGM Lounge" title="{{ $type }} {{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center lg:px-48">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <div class="text-center my-4 lg:mt-0 lg:mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold">
                        {{ "{$title}" }}
                    </h1>
                    <p>{{ "{$mission->expected_at->format('m월 d일 H시 i분')} {$type}에 대한 만족도 조사 결과 입니다." }}</p>
                </div>

                <div class="space-y-3 mb-6">
                    <x-alert.info title="미션 메이커님께">
                        <ul>
                            <li>고생 많으셨습니다! 회원 {{ $countParticipant }}명이 본 만족도 조사에 참가해주셨습니다.</li>
                            <li>회원님께서 보내주신 소중한 의견입니다. 다음 미션 제작시 참고해 주시면 감사드립니다.</li>
                            <li>주관식 답변 중 인신공격, 모욕을 발견할 경우 먼저 스탭에게 알려주시기 바랍니다.</li>
                        </ul>
                    </x-alert.info>
                </div>

                <div class="">
                    @foreach($data as $datum)
                        <div class="pb-8">
                            <div class="flex space-x-2">
                                @if($datum['type'] == 'radio')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        객관식
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        주관식
                                    </span>
                                @endif
                                <p class="font-bold">{{ $datum['title'] }}</p>
                            </div>

                            @if($datum['type'] === 'radio')
                                <div class="py-4 flex justify-center">
                                    <div class="lg:w-1/2 mb-4">
                                        <canvas id="{{ "question{$loop->index}" }}"></canvas>
                                    </div>
                                </div>
                            @else
                                <div class="py-4">
                                    <div class="mb-4">
                                        @if($isStaff)
                                            <x-alert.danger title="주의">
                                                <ul>
                                                    <li>주관식 문항 작성자는 관리자에게만 표시됩니다.</li>
                                                    <li>회원 정보가 표시 되지 않도록 주의하십시오.</li>
                                                </ul>
                                            </x-alert.danger>
                                        @endif
                                        <ul class="divide-y divide-gray-200 pt-2">
                                            @foreach($datum['userAnswer'] as $userAnswer)
                                                <li class="py-2">
                                                    <div class="flex space-x-3">
                                                        @if($isStaff)
                                                            <a href="{{ route('staff.user.read', $userAnswer['user']->id) }}" target="_blank" class="link-indigo pb-1">{{ $userAnswer['user']->nickname }}</a>
                                                        @endif
                                                        <p class="text-sm text-gray-600">
                                                            {{ $userAnswer['answer'] }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
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
                    <x-button.filled.md-white type="button" onclick="location.href='{{ route('lounge.mission.read', $id) }}'">
                        돌아가기
                    </x-button.filled.md-white>
                </div>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
