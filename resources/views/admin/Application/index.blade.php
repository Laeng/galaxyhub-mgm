<x-theme.galaxyhub.sub-content title="가입 신청자" description="가입 신청자 목록" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '가입 신청자')">
    <x-panel.galaxyhub.basics>
        <div class="grid grid-cols-1 gap-3 mb-3">
            <x-alert.galaxyhub.warning title="알려드립니다.">
                <ul>
                    <li>{{ now()->subYears(18)->year . '년생 이상만 가입을 허용해 주십시오. (' . now()->year . '년 기준)' }}</li>
                    <li>미비 사항이 있다면 무조건 거절하시지 마시고 보류 처리 후 해당 부분을 보충할 기회를 주십시오.</li>
                    <li>거절, 보류 사유는 해당 신청자에게 표시됩니다. 민감한 사항은 '유저 기록' 에 별도 기록해 주십시오.</li>
                </ul>
            </x-alert.galaxyhub.warning>
        </div>
        <div>
            <x-list.galaxyhub.basics :component-id="'LIST_' . \Str::upper(\Str::random(6))" name="user_id" :action="route('admin.application.index.data')" refresh="false"/>
        </div>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
