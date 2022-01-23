<x-sub-page website-name="MGM Lounge" title="아르마3 퀴즈">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center lg:px-48">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <div class="text-center my-4 lg:mt-0 lg:mb-8">
                    <h1 class="text-2xl lg:text-3xl font-bold">
                        아르마3 퀴즈
                    </h1>
                </div>
                <x-survey.form :survey="$survey" :action="$action" submit-text="제출"/>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
