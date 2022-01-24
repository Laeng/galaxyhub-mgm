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

                <div class="flex flex-col mb-4" x-data="mission_list">
                    <div class="space-y-3">
                        <div class="hidden md:flex items-center">
                            <div class="w-full lg:w-auto mr-3">
                                <x-input.select.primary id="group" name="group" x-model="data.list.body.query.type" required>
                                    <option value="">모든 분류</option>
                                    @foreach($types as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </x-input.select.primary>
                            </div>
                            <div class="w-full lg:w-auto mr-3">
                                <x-input.select.primary id="group" name="group" x-model="data.list.body.query.phase" required>
                                    <option value="">모든 상태</option>
                                    @foreach($phase as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </x-input.select.primary>
                            </div>
                            <div class="w-full lg:w-auto mr-3">
                                <x-input.select.primary id="filter" name="filter" x-model="data.list.body.query.filter" required>
                                    <option value="">모든 미션</option>
                                    <option value="종료된 미션 제외">종료된 미션 제외</option>
                                </x-input.select.primary>
                            </div>
                            <div class="w-full lg:w-auto mr-3">
                                <x-input.select.primary id="limit" name="limit" x-model="data.list.body.limit" required>
                                    <option value="">보기</option>
                                    <option value="10">10개</option>
                                    <option value="20">20개</option>
                                    <option value="30">30개</option>
                                    <option value="50">50개</option>
                                </x-input.select.primary>
                            </div>

                            @if($isMaker)
                                <div class="md:ml-auto">
                                    <div class="flex justify-end space-x-2">
                                        <x-button.filled.md-blue type="button" onClick="location.href='{{ route('lounge.mission.create') }}'">
                                            미션 생성
                                        </x-button.filled.md-blue>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <x-table.simple :component-id="$listComponentId" :api-url="route('lounge.mission.list.api')" :use-check-box="false" :refresh="true" limit="10" x-ref="missions" query="{filter:'종료된 미션 제외'}" />

                    </div>
                </div>

                <script type="text/javascript">
                    window.document.addEventListener('alpine:init', () => {
                        window.alpine.data('mission_list', () => ({
                            data: {
                                list: {
                                    body: {
                                        limit: 10,
                                        query: {
                                            type: '',
                                            phase: '',
                                            filter: '종료된 미션 제외'
                                        },
                                    },
                                },
                            },
                            init() {
                                let table = this.$store.{{$listComponentId}};

                                this.$watch('data.list.body.limit', (v) => {
                                    table.data.list.body.limit = v;
                                    table.list();
                                });

                                this.$watch('data.list.body.query.type', (v) => {
                                    table.data.list.body.query.type = v;
                                    table.list();
                                });

                                this.$watch('data.list.body.query.phase', (v) => {
                                    table.data.list.body.query.phase = v;
                                    table.list();
                                });

                                this.$watch('data.list.body.query.filter', (v) => {
                                    table.data.list.body.query.filter = v;
                                    table.list();
                                });

                                table.list();
                            },
                        }));
                    });
                </script>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
