<x-theme.galaxyhub.sub-basics-account :title="$title" :user="$user">
    <x-panel.galaxyhub.basics>
        <div class="flex flex-col space-y-2">
            <x-alert.galaxyhub.info title="장기 미접속 안내">
                <ul>
                    <li>장기 미접속은 30일 이상 미션에 참여하지 않는 것입니다.</li>
                    <li>사정에 의해 부득이하게 30일 이상 미션에 참여할 수 없는 경우 장기 미접속 신청하시기 바랍니다.</li>
                    <li>장기 미접속 신청은 미션 참가 기록이 있는 회원만 가능합니다.</li>
                </ul>
            </x-alert.galaxyhub.info>

            @if(!$canPause)
                <x-alert.galaxyhub.info title="장기 미접속 신청 불가">
                    <p>{{ $user->name }}님께서는 미션에 참석하시지 않으셨으므로 장기 미접속 신청을 하실 수 없습니다.</p>
                </x-alert.galaxyhub.info>
            @endif

        </div>

        <div class="mt-8">
            <h2 class="text-xl lg:text-2xl font-bold">장기 미접속</h2>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">현재 {{ $user->name }}님께서는 장기 미접속 신청 @if($isPause) 하셨습니다. @elseif($canPause) 하실 수 있습니다. @else 하실 수 없습니다. @endif</p>
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-basics-account>
