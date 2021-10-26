<x-sub-page website-name="MGM Lounge" title="{{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{$title}}</h1>

                <div class="flex-col space-y-2 mb-4">
                    @foreach($alerts as $v)
                        <x-dynamic-component :component="'alert.' .$v[0]" :title="$v[1]">
                            {!! $v[2] !!}
                        </x-dynamic-component>
                    @endforeach
                </div>

                <div class="flex flex-col mb-4">
                    <x-table.simple :api-url="$applicantsListApi" :use-check-box="true" :use-check-box-name="'id'" />
                </div>


            </div>
        </div>
    </x-section.basic>
</x-sub-page>
