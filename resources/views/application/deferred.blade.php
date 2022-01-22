<x-sub-page website-name="MGM Lounge" title="가입 보류됨">
    <x-section.basic parent-class="py-4 sm:py-6" class="flex justify-center items-center">
        <div class="w-full md:w-2/3">
            <div class="py-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center my-4 lg:mt-0 lg:mb-6">가입 보류 안내</h1>
                <div class="text-center">
                    <p>
                        가입이 보류되었습니다. <br/>
                        @if(!is_null($reason) && $reason !== '')
                            아래 보류 사유를 확인 하신 후 다시 신청해 주시기 바랍니다.
                        @endif
                    </p>
                    <p class="font-medium my-4">{{ $reason }}</p>
                </div>
                <div class="flex justify-center pt-6 pb-4 lg:pb-0 space-x-2">
                    <x-button.filled.md-white type="button" onclick="location.href='{{ route('application.agreements') }}'">
                        다시 신청하기
                    </x-button.filled.md-white>
                </div>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
