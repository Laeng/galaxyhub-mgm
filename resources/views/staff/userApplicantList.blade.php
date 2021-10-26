<x-sub-page website-name="MGM Lounge" title="{{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{$title}}</h1>

                <div class="flex-col space-y-2 mb-4">
                    @foreach($alerts as $alert)
                        <x-dynamic-component :component="'alert.' .$alert[0]" :title="$alert[1]">
                            {!! $alert[2] !!}
                        </x-dynamic-component>
                    @endforeach
                </div>

                <div class="flex flex-col mb-4">
                    <form x-data="applicant_list_form()" x-ref="form">
                        <x-table.simple :api-url="$applicantsListApi" :use-check-box="true" :check-box-name="'id'" />

                        <div class="flex justify-start space-x-3 mt-2">
                            <x-button.filled.md-white>
                                승인
                            </x-button.filled.md-white>
                            <x-button.filled.md-white>
                                거절
                            </x-button.filled.md-white>
                            <x-button.filled.md-white>
                                보류
                            </x-button.filled.md-white>
                        </div>
                    </form>

                    <script type="text/javascript">
                        function applicant_list_form() {
                            return {
                                accept() {
                                    $refs.form.setAttribute('action', '');
                                },
                                reject() {

                                },
                                defer() {

                                }
                            };
                        }
                    </script>
                </div>

            </div>
        </div>
    </x-section.basic>
</x-sub-page>
