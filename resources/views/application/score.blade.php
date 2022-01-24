<x-sub-page website-name="MGM Lounge" title="퀴즈 결과">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center lg:px-48">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <div class="relative text-center my-4 lg:mt-0 lg:mb-8">
                    <h1 class="text-2xl lg:text-3xl font-bold">
                        퀴즈 결과
                    </h1>
                    @if($matches >= 3)
                        <div class="absolute right-4 md:right-16 lg:right-0 xl:right-8 top-0 xl:-top-2 -rotate-12 rounded-xl border border-double border-8 border-red-500 mix-blend-multiply" style="-webkit-mask-image: url('{{ asset('image/rubber.png') }}'); -webkit-mask-repeat:repeat; -webkit-mask-position: {{mt_rand(0, 64)}}px {{mt_rand(0, 64)}}px;">
                            <div class="p-2 xl:p-4 text-red-500 flex flex-col">
                                <p class="text-4xl xl:text-5xl font-bold lg:font-black">
                                    PASSED
                                </p>
                                <p class="text-[0.64rem] lg:text-[0.66rem] xl:text-sm -mt-2">
                                    Multiplay Game Management
                                </p>
                            </div>
                        </div>
                    @else
                        {{--
                        <div class="absolute right-4 md:right-16 lg:right-0 xl:right-8 top-0 xl:-top-4 -rotate-12 rounded-xl border border-double border-8 border-red-500 mix-blend-multiply" style="-webkit-mask-image: url('{{ asset('image/rubber.png') }}'); -webkit-mask-repeat:repeat; -webkit-mask-position: {{mt_rand(0, 64)}}px {{mt_rand(0, 64)}}px;">
                            <div class="p-2 xl:p-4 text-red-500 flex flex-col">
                                <p class="text-[2.6rem] leading-10 xl:text-[3.4rem] xl:leading-none font-bold lg:font-black">
                                    FAILED
                                </p>
                                <p class="text-[0.6rem] lg:text-[0.66rem] xl:text-sm -mt-2">
                                    Multiplay Game Management
                                </p>
                            </div>
                        </div>
                        --}}
                    @endif
                </div>

                <div class="space-y-3 mb-6">
                    @if($matches >= 3)
                        <x-alert.success title="축하드립니다!">
                            <ul>
                                <li>{{ $user->nickname }}님께서는 5개의 문제 중 {{ $matches }}개를 맞추셨습니다!</li>
                                <li>MGM 아르마 클랜을 희망하신다면, 아래의 '가입 신청서 작성하기' 버튼을 눌러주세요.</li>
                            </ul>
                        </x-alert.success>
                    @else
                        <x-alert.info title="앗... 이런...">
                            <ul>
                                <li>{{ $user->nickname }}님께서는 5개의 문제 중 {{ $matches }}개를 맞추셨습니다. 원활한 아르마 플레이를 위해서는 3문제 이상 맞추셔야 합니다.</li>
                                <li>모든 문제는 <a href="https://cafe.naver.com/gamemmakers/book5076085" target="_blank" class="underline hover:no-underline font-bold">아르마 길잡이</a>에서 출제 됩니다. 아직 읽어보지 못하셨다면 한번 읽어보세요!</li>
                                <li>{{ $user->nickname }}님께서는 운영 정책에 따라 7일 뒤인 {{ $survey->created_at->copy()->addDays(7)->format('Y년 m월 d일 H시 i분') }}에 재도전 하실 수 있습니다.</li>
                            </ul>
                        </x-alert.info>
                    @endif
                </div>

                <x-survey.form :survey="$survey" :action="''" :answer="$answer"/>

                @if($matches >= 3)
                    <form action="{{ route('application.form') }}" method="post">
                        @csrf
                        <div class="flex justify-center mt-4 space-x-2">
                            <x-button.filled.md-blue type="submit">
                                가입 신청서 작성하기
                            </x-button.filled.md-blue>
                        </div>
                    </form>
                @else
                    <div class="flex justify-center mt-4 space-x-2">
                        <x-button.filled.md-white type="button" onclick="location.href='{{ route('application.index') }}'">
                            확인
                        </x-button.filled.md-white>
                    </div>
                @endif
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
