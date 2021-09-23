<x-sub-page website-name="MGM Lounge" title="가입">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">MGM Lounge 및 클랜 가입</h1>
                <x-survey.form :survey="$survey" :action="$action" submit-text="가입 신청서 제출"/>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
