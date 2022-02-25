@php
    $componentId = 'LIST_' . \Str::upper(\Str::random(6));
@endphp

<x-theme.galaxyhub.sub-content title="미션 목록" description="아르마3 미션 목록" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app', '미션')">
    <x-panel.galaxyhub.basics>
        <div class="flex flex-col space-y-2" x-data="mission_list">
            @foreach($messages as $message)
                <x-dynamic-component :component="'alert.' .$message[0]" :title="$message[1]">
                    {!! $message[2] !!}
                </x-dynamic-component>
            @endforeach
            <div class="flex items-center">
                <div class="w-full lg:w-auto mr-3 hidden md:block">
                    <x-input.select.basics id="group" name="group" x-model="data.list.body.query.type" required>
                        <option value="">모든 분류</option>
                        @foreach($types as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </x-input.select.basics>
                </div>
                <div class="w-full lg:w-auto mr-3 hidden md:block">
                    <x-input.select.basics id="group" name="group" x-model="data.list.body.query.phase" required>
                        <option value="">모든 상태</option>
                        @foreach($phase as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </x-input.select.basics>
                </div>
                <div class="w-full lg:w-auto mr-3 hidden md:block">
                    <x-input.select.basics id="filter" name="filter" x-model="data.list.body.query.filter" required>
                        <option value="">모든 미션</option>
                        <option value="종료된 미션 제외">종료된 미션 제외</option>
                    </x-input.select.basics>
                </div>
                <div class="w-full lg:w-auto md:mr-3">
                    <x-input.select.basics id="limit" name="limit" x-model="data.list.body.limit" required>
                        <option value="">보기</option>
                        <option value="10">10개</option>
                        <option value="20">20개</option>
                        <option value="30">30개</option>
                        <option value="50">50개</option>
                    </x-input.select.basics>
                </div>
                @if($isMaker)
                    <div class="md:ml-auto hidden md:block">
                        <div class="flex justify-end space-x-2">
                            <x-button.filled.md-blue type="button" onClick="location.href='{{ route('mission.new') }}'">
                                미션 생성
                            </x-button.filled.md-blue>
                        </div>
                    </div>
                @endif
            </div>
            <x-list.galaxyhub.basics :component-id="$componentId" name="" :action="route('mission.list')" :refresh="true" query="{filter:'종료된 미션 제외'}"/>
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
                        let table = this.$store.{{$componentId}};

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

    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
