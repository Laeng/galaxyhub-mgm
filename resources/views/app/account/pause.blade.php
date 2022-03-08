<x-theme.galaxyhub.sub-basics-account :title="$title" :user="$user">
    <x-panel.galaxyhub.basics>
        <div class="flex flex-col space-y-2">
            @if($isPause)
                <x-alert.galaxyhub.warning title="장기 미접속을 신청하셨습니다.">
                    <ul>
                        <li>장기 미접속 신청이 접수되면 미션 참여와 프로그램 사용이 불가합니다.</li>
                        <li>만약 활동을 재개하시기로 결정하셨다면 아래 '장기 미접속 해제' 버튼을 눌러주십시오.</li>
                    </ul>
                </x-alert.galaxyhub.warning>
            @else
                <x-alert.galaxyhub.info title="장기 미접속 안내">
                    <ul>
                        <li>장기 미접속은 30일 이상 미션에 참여하지 않는 것입니다.</li>
                        <li>사정에 의해 부득이하게 30일 이상 미션에 참여할 수 없는 경우 장기 미접속 신청하시기 바랍니다.</li>
                        <li>장기 미접속 신청은 미션 참가 기록이 있는 회원만 가능합니다.</li>
                    </ul>
                </x-alert.galaxyhub.info>
            @endif
        </div>

        <div class="mt-8">
            <h2 class="text-xl lg:text-2xl font-bold">장기 미접속</h2>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">현재 {{ $user->name }}님께서는 장기 미접속 신청을 @if($isPause) 하셨습니다. @elseif($canPause) 하실 수 있습니다. @else 하실 수 없습니다. @endif</p>
        </div>

        <div x-data="account_pause">
            @if($isPause)
                <div class="mt-8 text-center">
                    <x-button.filled.md-white @click="pause('장기 미접속 해제를 하시겠습니까?')">
                        장기 미접속 해제
                    </x-button.filled.md-white>
                </div>
            @elseif($canPause)
                <div class="mt-8 text-center" @click="pause('장기 미접속 신청을 하시겠습니까?')">
                    <x-button.filled.md-red>
                        장기 미접속 신청
                    </x-button.filled.md-red>
                </div>
            @endif
        </div>


        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('account_pause', () => ({
                    data: {
                        pause: {
                            url: '@if($isPause) {{ route('account.pause.disable') }} @elseif($canPause) {{ route('account.pause.enable') }} @endif',
                            body: {},
                            lock: false
                        },
                    },
                    pause(message) {
                        window.modal.confirm('장기 미접속', message, (r) => {
                            if (r.isConfirmed) {
                                let success = (r) => {
                                    window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {
                                        location.reload();
                                    });
                                }
                                let error = (e) => {
                                    if (typeof e.response !== 'undefined') {
                                        if (e.response.status === 415) {
                                            //CSRF 토큰 오류 발생
                                            window.modal.alert('처리 실패', '로그인 정보를 확인할 수 없습니다.', (c) => {
                                                location.reload();
                                            }, 'error');
                                            return;
                                        }

                                        if (e.response.status === 422) {
                                            let msg = '';
                                            switch (e.response.data.description) {
                                                case "CONTACT TO MANAGER":
                                                    msg = '장기 미접속 처리 중 문제가 발생하였습니다. 관리자에게 문의하여 주십시오.';
                                                    break;
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
                                }
                                let complete = () => {
                                    this.data.pause.lock = false;
                                }

                                if (!this.data.pause.lock) {
                                    this.data.pause.lock = true;
                                    this.post(this.data.pause.url, this.data.pause.body, success, error, complete);
                                }
                            }
                        });
                    },
                    post(url, body, success, error, complete) {
                        window.axios.post(url, body).then(success).catch(error).then(complete);
                    }
                }));
            });
        </script>

    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-basics-account>
