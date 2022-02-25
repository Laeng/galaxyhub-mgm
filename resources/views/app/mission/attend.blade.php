<x-theme.galaxyhub.sub-content title="출석" description="출석" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.mission', '출석')">
    <x-panel.galaxyhub.basics>
        <div class="py-8" x-data="mission_attend">
            <div class="text-center">
                <h2 class="text-xl lg:text-2xl font-bold">출석하기</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">{{ $mission->title }}</p>
            </div>
            <div class="flex justify-center py-4">
                <div class="w-48">
                    <x-input.text.basics class="text-center text-4xl font-bold tabular-nums" maxlength="6" placeholder="∗ ∗ ∗ ∗" x-model="data.attend.body.code" @keyup.enter="attend()"/>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="w-48">
                    <x-button.filled.md-blue type="button" class="w-full" @click="attend()">
                        출석하기
                    </x-button.filled.md-blue>

                    <div class="text-center mt-2">
                        <a class="text-sm text-gray-400 underline hover:text-gray-900 hover:no-underline" href="{{ route('mission.read', $mission->id) }}">
                            출석하지 않기
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('mission_attend', () => ({
                    data: {
                        attend: {
                            url: '{{route('mission.read.attend.try', $mission->id)}}',
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
                                        window.modal.alert('출석 완료', '{{ $mission->title }}, 출석되었습니다.', (c) => {
                                            location.href = '{{ route('mission.read', $mission->id) }}';
                                        });
                                    } else {
                                        let left = r.data.data.limit - r.data.data.count;

                                        window.modal.alert('출석 실패', '출석 코드가 맞지 않습니다. 남은 횟수: ' + left + '/' + r.data.data.limit, (c) => {
                                            if (left <= 0) {
                                                window.modal.alert('안내', '출석 시도 횟수 초과로 출석 실패 처리 되었습니다.', (c) => {
                                                    location.href = '{{ route('mission.read', $mission->id) }}';
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
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
