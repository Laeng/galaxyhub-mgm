@php
    $listComponentId = 'table_' . Str::lower(Str::random(5));
@endphp
<x-sub-page website-name="MGM Lounge" title="{{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{$title}}</h1>

                <div class="flex flex-col mb-4">
                    <div class="space-y-3" x-data="all_list">
                        <div class="flex flex-wrap space-y-1 xl:space-y-0">
                            <div class="hidden xl:flex items-center space-x-3">
                                <p class="text-gray-600 hidden md:block">선택 회원을</p>
                                <div>
                                    <x-input.select.primary id="group" name="group" x-model="data.group.body.group" required>
                                        <option value="">등급 선택</option>
                                        <option value="알티스">알티스</option>
                                    </x-input.select.primary>
                                </div>
                                <p class="text-gray-600 hidden md:block">(으)로</p>
                                <x-button.filled.md-white @click="process('accept', '가입 승인', '가입을 승인 하시겠습니까?', false)" type="button">
                                    변경
                                </x-button.filled.md-white>
                                <p class="border h-6"></p>
                                <x-button.filled.md-white @click="process('reject', '가입 거절', '거절 사유를 입력해 주십시오.')" type="button">
                                    활동 정지
                                </x-button.filled.md-white>
                                <x-button.filled.md-white @click="process('defer', '가입 보류', '보류 사유를 입력해 주십시오.')" type="button">
                                    강제 탈퇴
                                </x-button.filled.md-white>
                            </div>

                            <div class="xl:ml-auto hidden md:flex flex-row items-center space-x-3">
                                <div class="w-full lg:w-auto">
                                    <x-input.select.primary id="group" name="group" x-model="data.list.body.query.group" required>
                                        <option value="">전체 회원</option>
                                        <option value="10">활동정지</option>
                                        <option value="11">장기미접속</option>
                                        <option value="20">가입 신청</option>
                                        <option value="21">가입 보류</option>
                                        <option value="22">가입 거절</option>
                                        <option value="30">멤버</option>
                                        <option value="50">예비 메이커</option>
                                        <option value="51">정식 메이커</option>
                                        <option value="70">시니어</option>
                                        <option value="90">관리자</option>
                                    </x-input.select.primary>
                                </div>
                                <div class="w-full lg:w-auto">
                                    <x-input.select.primary id="group" name="group" x-model="data.list.body.query.order" required>
                                        <option value="">정렬</option>
                                        <option value="가입일 오른차순">가입일 오른차순</option>
                                        <option value="가입일 내림차순">가입일 내림차순</option>
                                        <option value="방문일 오른차순">방문일 오른차순</option>
                                        <option value="방문일 내림차순">방문일 내림차순</option>
                                        <option value="미션 참가일 오른차순">미션 참가일 오른차순</option>
                                        <option value="미션 참가일 내림차순">미션 참가일 내림차순</option>

                                    </x-input.select.primary>
                                </div>
                                {{-- 최근의 기준은 어떤 것인가...
                                <div class="w-full lg:w-auto">
                                    <x-input.select.primary id="group" name="group" x-model="data.list.body.query.term" required>
                                        <option value="">전체 기간</option>
                                        <option value="1일">최근 1일</option>
                                        <option value="3일">최근 3일</option>
                                        <option value="1주">최근 1주</option>
                                        <option value="2주">최근 2주</option>
                                        <option value="1개월">최근 1개월</option>
                                        <option value="3개월">최근 3개월</option>
                                        <option value="6개월">최근 6개월</option>
                                        <option value="1년">최근 1년</option>
                                        <option value="3년">최근 3년</option>
                                    </x-input.select.primary>
                                </div>
                                --}}
                                <div class="w-full lg:w-auto">
                                    <x-input.select.primary id="group" name="group" x-model="data.list.body.limit" required>
                                        <option value="">보기</option>
                                        <option value="10">10명</option>
                                        <option value="20">20명</option>
                                        <option value="30">30명</option>
                                        <option value="50">50명</option>
                                        <option value="100">100명</option>
                                    </x-input.select.primary>
                                </div>
                            </div>
                        </div>

                        <x-table.simple :component-id="$listComponentId" :api-url="route('staff.user.api.all.list')" :use-check-box="true" :check-box-name="'user_id'" x-ref="users" />

                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-3">
                                <p class="text-gray-600 hidden md:block">선택 회원을</p>
                                <div>
                                    <x-input.select.primary id="group" name="group" x-model="data.group.body.group" required>
                                        <option value="">등급 선택</option>
                                        <option value="알티스">알티스</option>
                                    </x-input.select.primary>
                                </div>
                                <p class="text-gray-600 hidden md:block">(으)로</p>
                                <x-button.filled.md-white @click="process('accept', '가입 승인', '가입을 승인 하시겠습니까?', false)" type="button">
                                    변경
                                </x-button.filled.md-white>
                                <p class="border h-6"></p>
                                <x-button.filled.md-white @click="process('reject', '가입 거절', '거절 사유를 입력해 주십시오.')" type="button">
                                    활동 정지
                                </x-button.filled.md-white>
                                <x-button.filled.md-white @click="process('defer', '가입 보류', '보류 사유를 입력해 주십시오.')" type="button">
                                    강제 탈퇴
                                </x-button.filled.md-white>
                            </div>
                        </div>
                    </div>


                    <script type="text/javascript">
                        window.document.addEventListener('alpine:init', () => {
                            window.alpine.data('all_list', () => ({
                                data: {
                                    list: {
                                        body: {
                                            limit: 20,
                                            query: {
                                                group: '전체 회원',
                                                order: '가입일 내림차순',
                                                term: '전체 기간'
                                            },
                                        },
                                    },
                                    group: {
                                        body: {
                                            group: ''
                                        }
                                    }
                                },
                                process(a, b, c, d) {},
                                init() {
                                    let table = this.$store.{{$listComponentId}};

                                    this.$watch('data.list.body.limit', (v) => {
                                        table.data.list.body.limit = v;
                                        table.list();
                                    });

                                    this.$watch('data.list.body.query.group', (v) => {
                                        table.data.list.body.query.group = v;
                                        table.list();
                                    });

                                    this.$watch('data.list.body.query.order', (v) => {
                                        table.data.list.body.query.order = v;
                                        table.list();
                                    });

                                    this.$watch('data.list.body.query.term', (v) => {
                                        table.data.list.body.query.term = v;
                                        table.list();
                                    });
                                },
                            }));
                        });
                    </script>
                </div>

            </div>
        </div>
    </x-section.basic>
</x-sub-page>
