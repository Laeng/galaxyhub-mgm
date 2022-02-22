@php
    $componentId = 'LIST_' . \Str::upper(\Str::random(6));
@endphp
<x-theme.galaxyhub.sub-content title="가입 신청자" description="가입 신청자 목록" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '가입 신청자')">
    <x-panel.galaxyhub.basics>
        <div class="flex flex-col space-y-2 mb-3">
            <x-alert.galaxyhub.warning title="유의사항">
                <ul>
                    <li>{{ now()->subYears(18)->year . '년생 이상만 가입을 허용해 주십시오. (' . now()->year . '년 기준)' }}</li>
                    <li>미비 사항이 있다면 무조건 거절하시지 마시고 보류 처리 후 해당 부분을 보충할 기회를 주십시오.</li>
                    <li>거절, 보류 사유는 해당 신청자에게 표시됩니다. 민감한 사항은 '유저 활동 기록' 에 별도 기록해 주십시오.</li>
                </ul>
            </x-alert.galaxyhub.warning>
        </div>
        <div>
            <x-list.galaxyhub.basics :component-id="$componentId" name="user_id" :action="route('admin.application.index.list')" refresh="false"/>
        </div>
        <div class="flex justify-start space-x-2 mt-3" x-data="application_list" >
            <x-button.filled.md-white @click="process('{{ \App\Enums\RoleType::MEMBER->name  }}', '가입 승인', '가입을 승인 하시겠습니까?', false)" type="button">
                승인
            </x-button.filled.md-white>
            <x-button.filled.md-white @click="process('{{ \App\Enums\RoleType::REJECT->name }}', '가입 거절', '거절 사유를 입력해 주십시오.')" type="button">
                거절
            </x-button.filled.md-white>
            <x-button.filled.md-white @click="process('{{ \App\Enums\RoleType::DEFER->name }}', '가입 보류', '보류 사유를 입력해 주십시오.')" type="button">
                보류
            </x-button.filled.md-white>
        </div>
        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('application_list', () => ({
                    data: {
                        process: {
                            url: '{{ route('admin.application.index.process') }}',
                            body: {},
                            lock: false
                        }
                    },
                    process(type, title, message, prompt = true) {
                        let checked = this.checked(document.querySelectorAll("input[name='user_id[]']:checked"));

                        if (checked.length <= 0) {
                            window.modal.alert('오류', '처리할 신청자를 선택하여 주십시오.', (c) => {}, 'error');
                            return;
                        }

                        let callback = (r) => {
                            if (r.isConfirmed) {
                                this.data.process.body = {
                                    type: type,
                                    user_id: checked,
                                    reason: (prompt) ? r.value : null
                                };

                                let success = (r) => {
                                    this.$store.{{ $componentId }}.checkbox('{{ $componentId }}', false);
                                    this.$store.{{ $componentId }}.list(this.$store.{{ $componentId }}.data.list.data.count.step);

                                    window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {});
                                };

                                let error = (e) => {
                                    if (typeof e.response !== 'undefined') {
                                        if (e.response.status === 401) {
                                            Location.reload();
                                        }

                                        if (e.response.status === 415) {
                                            //CSRF 토큰 오류 발생
                                            window.modal.alert('처리 실패', '로그인 정보를 확인할 수 없습니다.', (c) => {
                                                Location.reload();
                                            }, 'error');
                                            return;
                                        }

                                        if (e.response.status === 422) {
                                            let msg = '';
                                            switch (e.response.data.description) {
                                                default:
                                                    msg = e.response.data.description;
                                                    break;
                                            }

                                            window.modal.alert('처리 실패', msg, (c) => {}, 'error');
                                            return;
                                        }
                                    }

                                    window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                                    console.log(e);
                                };

                                let complete = () => {
                                    this.data.process.lock = false;
                                };

                                if (!this.data.process.lock) {
                                    this.data.process.lock = true;
                                    this.post(this.data.process.url, this.data.process.body, success, error, complete);
                                }
                            }
                        };

                        if (prompt) {
                            window.modal.prompt(title, message, (v) => {}, callback);
                        } else {
                            window.modal.confirm(title, message, callback, 'question', '예', '아니요');
                        }
                    },
                    checked(checkboxes) {
                        let checked = [];
                        [...checkboxes].map((el) => {checked.push(el.value);});

                        return checked;
                    },
                    post(url, body, success, error, complete) {
                        window.axios.post(url, body).then(success).catch(error).then(complete);
                    }
                }));
            });
        </script>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
