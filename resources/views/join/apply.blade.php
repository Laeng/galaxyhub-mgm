<x-sub-page website-name="MGM Lounge" title="가입">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center lg:px-48">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <div class="text-center my-4 lg:mt-0 lg:mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold">
                        가입 신청서
                    </h1>
                </div>
                <x-survey.form :survey="$survey" :action="$action" submit-text="가입 신청서 제출"/>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
