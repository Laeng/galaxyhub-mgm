@php
    $componentId1 = 'LIST_' . \Str::upper(\Str::random(6));
    $componentId2 = 'LIST_' . \Str::upper(\Str::random(6));
@endphp

<x-theme.galaxyhub.sub-basics-account :title="$title" :user="$user">
    <div class="space-y-8" x-data="account_mission">
        <x-panel.galaxyhub.basics>
            <div class="flex flex-col space-y-2">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold">신청한 미션</h2>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">
                        {{ $user->name }}님께서 지금까지 신청한 미션입니다.
                    </p>
                </div>
                <div class="flex items-center">
                    <div class="w-full lg:w-auto mr-2 hidden md:block">
                        <x-input.select.basics id="group" name="group" x-model="data.participate.body.query.type" required>
                            <option value="">모든 분류</option>
                            @foreach($types as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </x-input.select.basics>
                    </div>
                    <div class="w-full lg:w-auto md:mr-2">
                        <x-input.select.basics id="limit" name="limit" x-model="data.participate.body.limit" required>
                            <option value="">보기</option>
                            <option value="10">10개</option>
                            <option value="20">20개</option>
                            <option value="30">30개</option>
                            <option value="50">50개</option>
                        </x-input.select.basics>
                    </div>
                </div>
                <x-list.galaxyhub.basics :component-id="$componentId1" name="" :action="route('account.missions.participate')" :refresh="true"/>
            </div>
        </x-panel.galaxyhub.basics>

        <x-panel.galaxyhub.basics>
            <div class="flex flex-col space-y-2">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold">만든 미션</h2>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">
                        {{ $user->name }}님께서 지금까지 만든 미션입니다.
                    </p>
                </div>
                <div class="flex items-center">
                    <div class="w-full lg:w-auto mr-2 hidden md:block">
                        <x-input.select.basics id="group" name="group" x-model="data.make.body.query.type" required>
                            <option value="">모든 분류</option>
                            @foreach($types as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </x-input.select.basics>
                    </div>
                    <div class="w-full lg:w-auto md:mr-2">
                        <x-input.select.basics id="limit" name="limit" x-model="data.make.body.limit" required>
                            <option value="">보기</option>
                            <option value="10">10개</option>
                            <option value="20">20개</option>
                            <option value="30">30개</option>
                            <option value="50">50개</option>
                        </x-input.select.basics>
                    </div>
                </div>
                <x-list.galaxyhub.basics :component-id="$componentId2" name="" :action="route('account.missions.make')" :refresh="true"/>
            </div>
        </x-panel.galaxyhub.basics>
    </div>
    <script type="text/javascript">
        window.document.addEventListener('alpine:init', () => {
            window.alpine.data('account_mission', () => ({
                data: {
                    participate: {
                        body: {
                            limit: 10,
                            query: {
                                type: '',
                            },
                        },
                    },
                    make: {
                        body: {
                            limit: 10,
                            query: {
                                type: '',
                            },
                        },
                    },
                },
                init() {
                    let participate = this.$store.{{$componentId1}};
                    let make = this.$store.{{$componentId2}};

                    this.$watch('data.participate.body.limit', (v) => {
                        participate.data.list.body.limit = v;
                        participate.list();
                    });

                    this.$watch('data.participate.body.query.type', (v) => {
                        participate.data.list.body.query.type = v;
                        participate.list();
                    });

                    this.$watch('data.make.body.limit', (v) => {
                        make.data.list.body.limit = v;
                        make.list();
                    });

                    this.$watch('data.make.body.query.type', (v) => {
                        make.data.list.body.query.type = v;
                        make.list();
                    });

                    participate.list();
                    make.list();
                },
                post(url, body, success, error, complete) {
                    window.axios.post(url, body).then(success).catch(error).then(complete);
                }
            }));
        });
    </script>

</x-theme.galaxyhub.sub-basics-account>
