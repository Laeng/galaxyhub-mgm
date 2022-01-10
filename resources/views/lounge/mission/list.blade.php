@php
    $listComponentId = 'table_' . Str::lower(Str::random(5));
@endphp
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
                    <div>
                        <x-table.simple :component-id="$listComponentId" :api-url="route('lounge.mission.list.api')" :use-check-box="false" :refresh="true" x-ref="missions" />
                    </div>
                </div>

                <div>
                    @if($isMaker)
                        <div class="flex justify-end space-x-2">
                            <x-button.filled.md-blue type="button" onClick="location.href='{{ route('lounge.mission.create') }}'">
                                미션 생성
                            </x-button.filled.md-blue>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
