@php
    $carbon = \Carbon\Carbon::instance(new DateTime($date));
@endphp
<x-sub-page website-name="MGM Lounge" title="메인">
    <x-section.basic parent-class="py-4 sm:py-6" class="flex justify-center items-center">
        <div class="w-full md:w-2/3">
            <div class="py-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center my-4 lg:mt-0 lg:mb-6">가입 거절 안내</h1>
                <div class="text-center">
                    <p>
                        가입이 거절되었습니다. 현재 {{ $x }}회 가입 거절 되셨으며
                        @if($x >= 2)
                            규정에 따라 가입을 하실 수 없습니다.
                        @else
                            {{ $carbon->format('Y년 m월 d일') }}로부터 30일 이후에 다시 가입을 신청할 수 있습니다.
                        @endif
                        가입 거절 사유는 다음과 같습니다.
                    </p>
                    <p class="font-medium my-4">{{ $reason }}</p>
                    <p class="text-sm">"데이터 삭제" 버튼을 통해 가입을 위해 제출한 정보를 삭제할 수 있습니다. 가입 거절 내역의 경우 개인정보취급방침에 따라 일정 기간 저장 됨을 알려드립니다.</p>
                </div>
                <div class="flex justify-center pt-6 pb-4 lg:pb-0 space-x-2">
                    @if($x < 2 &&  $carbon->diffInDays(\Carbon\Carbon::now()) >= 30)
                    <x-button.filled.md-white type="button" onclick="location.href='{{ route('join.agree') }}'">
                        다시 신청하기
                    </x-button.filled.md-white>
                    @endif
                    <x-button.filled.md-white type="button" onclick="location.href='{{ route('join.agree') }}'">
                        데이터 삭제
                    </x-button.filled.md-white>
                </div>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
