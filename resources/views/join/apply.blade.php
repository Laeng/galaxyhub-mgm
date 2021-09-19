<x-sub-page website-name="MGM Lounge" title="가입">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full lg:w-4/5">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">MGM Lounge 가입</h1>
                @if($isJoinUnable)
                    <div class="flex flex-col space-y-2 mb-4">
                        <x-alert.danger title="MGM Lounge 가입 불가">
                            {!! $unableReason !!}
                        </x-alert.danger>
                        <x-alert.warning title="알려드립니다">
                            스팀 API 문제로 인해 변경된 프로필 또는 구매 내역이 반영 되는데 시간이 다소 걸릴 수 있습니다.
                        </x-alert.warning>
                    </div>
                @endif
                <div class="mb-4">
                    <h3 class="text-lg lg:text-xl font-bold py-2">개인정보처리방침 <span class="text-base font-normal">(필수 동의 항목)</span></h3>
                    <div class="rounded-lg border border-gray-200 py-4 pl-4">
                        <div class="h-64 overflow-y-scroll pr-4">
                            <x-agreement.privacy/>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <h3 class="text-lg lg:text-xl font-bold py-2">이용약관 <span class="text-base font-normal">(필수 동의 항목)</span></h3>
                    <div class="rounded-lg border border-gray-200 py-4 pl-4">
                        <div class="h-64 overflow-y-scroll pr-4">
                            <x-agreement.rules/>
                        </div>
                    </div>
                </div>
                @if($isJoinUnable)
                    <div class="flex justify-center pt-2 space-x-4">
                        <x-button.filled.md-white type="button" onclick="location.href='{{route('join.apply')}}'">
                            새로고침
                        </x-button.filled.md-white>
                    </div>
                @else
                    <p class="py-2 text-center">
                        개인정보처리방침 및 이용약관을 읽으셨으며 모두 동의하십니까?
                    </p>
                    <form action="{{ route('join.apply.submit') }}" method="post">
                        @csrf
                        <div class="flex justify-center pt-2 space-x-4">
                            <x-button.filled.md-blue>
                                예, 모두 동의합니다.
                            </x-button.filled.md-blue>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
