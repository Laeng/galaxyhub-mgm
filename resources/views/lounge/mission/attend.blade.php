<x-sub-page website-name="MGM Lounge" title="{{$title}}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center lg:px-48">
        <div class="w-full">
            <div class="bg-white rounded-lg p-16 lg:p-16">
                <div class="text-center mb-4 lg:mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold">일반 미션 출석</h1>
                    <p class="mt-2 flex justify-center">
                        <span class="hidden lg:block">미션 메이커가 여러분들께 전달해 드린&nbsp;</span>출석 코드를 입력해주세요.
                    </p>
                </div>

                <div class="flex justify-center" x-data="mission_attend">
                    <div class="block w-48">
                        <x-input.text.primary class="text-center text-4xl font-bold tabular-nums" maxlength="6" placeholder="∗ ∗ ∗ ∗" x-model="data.attend.body.code" @keyup.enter="attend()"/>

                        <x-button.filled.md-blue type="button" class="w-full mt-4" @click="attend()">
                            출석하기
                        </x-button.filled.md-blue>

                        <div class="text-center mt-2">
                            <a class="text-sm text-gray-400 underline hover:text-gray-900 hover:no-underline" href="{{ route('lounge.mission.read', $id) }}">
                                출석하지 않기
                            </a>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    window.document.addEventListener('alpine:init', () => {
                        window.alpine.data('mission_attend', () => ({
                            data: {
                                attend: {
                                    url: '{{route('lounge.mission.attend.process.api', $id)}}',
                                    body: {
                                        code: '',
                                    },
                                    lock: false
                                }
                            },
                            attend() {
                                let success = (r) => {
                                    if (r.data.data !== null) {
                                        if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                                            if (r.data.data.result) {
                                                window.modal.alert('출석 완료', '정상적으로 처리되었습니다.', (c) => {
                                                    location.href = '{{ route('lounge.mission.read', $id) }}';
                                                });
                                            } else {
                                                let left = r.data.data.limit - r.data.data.count;

                                                window.modal.alert('출석 실패', '출석 코드가 맞지 않습니다. 남은 횟수: ' + left + '/' + r.data.data.limit, (c) => {
                                                    if (left <= 0) {
                                                        window.modal.alert('안내', '출석 시도 횟수 초과로 출석 실패 처리 되었습니다.', (c) => {
                                                            location.href = '{{ route('lounge.mission.read', $id) }}';
                                                        }, 'error');
                                                    }
                                                }, 'error');
                                            }
                                        }
                                    }
                                };

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
                                                case 'ATTEND TIME EXPIRES':
                                                    msg = '출석이 마감되었습니다.';
                                                    break;
                                                case 'ALREADY IN ATTENDANCE':
                                                    msg = '이미 출석했습니다.';
                                                    break;
                                                case 'ATTEMPTS EXCEEDED':
                                                    msg = '출석 시도 횟수를 초과하여 출석할 수 없습니다.'
                                                    break;
                                                case 'VALIDATION FAILED':
                                                    msg = '출석 코드를 입력하여 주십시오.';
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
                                };

                                let complete = () => {
                                    this.data.attend.lock = false;
                                };

                                if (!this.data.attend.lock) {
                                    this.data.attend.lock = true;
                                    this.post(this.data.attend.url, this.data.attend.body, success, error, complete);
                                }
                            },
                            init() {

                            },
                            post(url, body, success, error, complete) {
                                window.axios.post(url, body).then(success).catch(error).then(complete);
                            }
                        }))
                    });
                </script>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
