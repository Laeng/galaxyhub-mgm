<x-theme.galaxyhub.sub-basics-account :title="$title" :user="$user">
    <x-panel.galaxyhub.basics>
        <div class="flex flex-col space-y-2">
            <x-alert.galaxyhub.warning title="주의">
                <ul>
                    <li>MGM Lounge에 저장된 귀하의 개인 정보를 삭제하여 MGM Lounge를 탈퇴할 수 있습니다.</li>
                    <li>데이터 삭제는 취소할 수 없으며 MGM Lounge에서 완전히 삭제되므로 복구할 수 없습니다.</li>
                    <li>단방향 암호화된 개인정보를 활용하여 서비스 개선을 위해 저장된 데이터는 탈퇴일로부터 5년간 저장됩니다.</li>
                </ul>
            </x-alert.galaxyhub.warning>
        </div>
        <div class="mt-8">
            <h2 class="text-xl lg:text-2xl font-bold">데이터 삭제</h2>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">
                MGM Lounge 에 저장된 계정 데이터를 삭제하여 MGM Lounge를 탈퇴할 수 있습니다.
            </p>
        </div>
        <div class="mt-8 text-center"  x-data="account_leave">
            <x-button.filled.md-red @click="leave()">
                데이터 삭제
            </x-button.filled.md-red>
        </div>

        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('account_leave', () => ({
                    data: {
                        leave: {
                            url: '{{ route('account.delete') }}',
                            body: {},
                            lock: false
                        },
                    },
                    leave() {
                        window.modal.confirm('데이터 삭제', '저장된 귀하의 데이터를 삭제하고 탈퇴하시겠습니까?', (r) => {
                            if (r.isConfirmed) {
                                let success = (r) => {
                                    window.modal.alert('처리 완료', '정상적으로 처리되었습니다.', (c) => {
                                        location.href = '{{ route('app.index') }}';
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
                                    }

                                    window.modal.alert('처리 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
                                    console.log(e);
                                }
                                let complete = () => {
                                    this.data.leave.lock = false;
                                }

                                if (!this.data.leave.lock) {
                                    this.data.leave.lock = true;
                                    this.post(this.data.leave.url, this.data.leave.body, success, error, complete);
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
