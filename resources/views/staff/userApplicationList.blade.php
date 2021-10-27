@php
    $listComponentId = 'l' . Str::random(5);
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
                    <div x-data="application_list_form()">
                        <x-table.simple :component-id="$listComponentId" :api-url="$applicantsListApi" :use-check-box="true" :check-box-name="'user_id'" x-ref="applicants" />

                        <div class="flex justify-start space-x-3 mt-3">
                            <x-button.filled.md-white @click="process('accept', '가입 승인', '가입을 승인 하시겠습니까?', false)" type="button">
                                승인
                            </x-button.filled.md-white>
                            <x-button.filled.md-white @click="process('reject', '가입 거부', '거부 사유를 입력해 주십시오.')" type="button">
                                거부
                            </x-button.filled.md-white>
                            <x-button.filled.md-white @click="process('defer', '가입 거부', '거부 사유를 입력해 주십시오.')" type="button">
                                보류
                            </x-button.filled.md-white>
                        </div>
                    </div>


                    <script type="text/javascript">
                        function application_list_form() {
                            return {
                                data: {
                                  reject: {
                                      lock: false
                                  }
                                },
                                process(type, title, message, prompt = true) {
                                    let callback = (r) => {
                                        if (r.isConfirmed) {
                                            let body = {
                                                type: 'reject',
                                                user_id: this.checked(document.querySelectorAll("input[name='user_id[]']:checked")),
                                                reason: (prompt) ? r.value : ''
                                            };

                                            let success = (r) => {
                                                window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {});

                                                this.$store.{{$listComponentId}}.checkbox(false);
                                                this.$store.{{$listComponentId}}.list(this.$store.{{$listComponentId}}.data.list.data.count.step);
                                            };

                                            let error = (e) => {
                                                window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                                                console.log(e);
                                            };

                                            let complete = () => {
                                                this.data.list.lock = false;
                                            };

                                            if (!this.data.list.lock) {
                                                this.data.list.lock = true;
                                                this.post(this.data.list.url, body, success, error, complete);
                                            }
                                        }
                                    };

                                    if (prompt) {
                                        window.modal.prompt(title, message, (v) => {}, callback);
                                    } else {
                                        window.modal.alert(title, message, callback, 'question');
                                    }
                                },
                                checked(checkboxes) {
                                    let checked = [];
                                    [...checkboxes].map((el) => {checked.add(el.value);});

                                    return checked;
                                },
                                post(url, body, success, error, complete) {
                                    window.axios.post(url, body).then(success).catch(error).then(complete);
                                }
                            };
                        }
                    </script>
                </div>

            </div>
        </div>
    </x-section.basic>
</x-sub-page>
