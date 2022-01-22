@push('js')
    <script defer src="{{ asset('/js/ckeditor.js') }}"></script>
@endpush

<x-sub-page website-name="MGM Lounge" title="{{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{$title}}</h1>

                <div class="" x-data="mission_create">
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                            <div class="">
                                <label for="type" class="block text-sm font-medium text-gray-700">
                                    미션 종류
                                </label>
                                <div class="mt-1">
                                    <x-input.select.primary id="type" name="type" x-model="data.create.body.type" required>
                                        <option value="">종류 선택</option>
                                        @foreach($types as $k => $v)
                                            <option value="{{$k}}">{{$v}}</option>
                                        @endforeach
                                    </x-input.select.primary>
                                </div>
                            </div>

                            <div class="pt-2 md:py-0">
                                <label class="block text-sm font-medium text-gray-700">
                                    시작 시간
                                </label>
                                <div class="mt-1 grid grid-cols-2 gap-x-2">
                                    <x-input.text.primary type="date" name="date" x-model="data.create.body.date" required/>
                                    <x-input.text.primary type="time" name="date" x-model="data.create.body.time" step="1800" required/>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4">
                            <div class="">
                                <label for="map" class="block text-sm font-medium text-gray-700">
                                    사용할 맵
                                </label>
                                <div class="mt-1">
                                    <x-input.select.primary id="type" name="map" x-model="data.create.body.map" required>
                                        <option value="">맵 선택</option>
                                        @foreach($maps as $k => $v)
                                            <option value="{{$k}}">{{$v}}</option>
                                        @endforeach
                                    </x-input.select.primary>
                                </div>
                            </div>
                            <div class="pt-2 md:py-0 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    사용할 애드온
                                </label>
                                <div class="h-11 flex justify-between items-center flex-wrap">
                                    @foreach($addons as $k => $v)
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="{{$k}}" aria-describedby="offers-description" name="addons[]" value="{{$k}}" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.addons">
                                            </div>
                                            <div class="ml-2 text-sm">
                                                <label for="{{$k}}" class="font-medium text-gray-700">{{$v}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mission-body prose max-w-full">
                            <label for="editor" class="block text-sm font-medium text-gray-700 pb-1">
                                미션 소개
                            </label>
                            <textarea id="editor" name="body" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md" placeholder="미션 정보 입력" x-model="data.create.body.body"></textarea>
                        </div>

                        <div class="flex justify-start">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="tardy" aria-describedby="offers-description" name="tardy" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.tardy">
                                </div>
                                <div class="ml-2 text-sm">
                                    <label for="tardy" class="font-medium text-gray-700">중도 참여 비허용</label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-center space-x-2">
                                <x-button.filled.md-blue type="button" @click="store()">
                                    등록
                                </x-button.filled.md-blue>
                                <x-button.filled.md-white type="button" onClick="location.replace('{{ back()->getTargetUrl() }}')">
                                    취소
                                </x-button.filled.md-white>
                            </div>
                        </div>

                    </div>

                    <script type="text/javascript">
                        window.document.addEventListener('alpine:init', () => {
                            window.alpine.data('mission_create', () => ({
                                data: {
                                    create: {
                                        url: @if($edit) '{{route('lounge.mission.update.api', $contents['id'])}}' @else '{{route('lounge.mission.create.api')}}' @endif,
                                        body: {!! json_encode($contents) !!},
                                        lock: false
                                    }
                                },
                                store() {
                                    let body = window.global.editor.getData();
                                    this.data.create.body.body = (body.length > 0) ? body : '미션 소개가 없습니다.';

                                    let success = (r) => {
                                        location.replace(r.data.data.url);
                                    }
                                    let error = (e) => {
                                        if (typeof e.response !== 'undefined') {
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
                                                    case "MISSION STATUS DOES'T MATCH THE CONDITIONS":
                                                        msg = '현재 미션 상태에서 실행할 수 없는 요청입니다.';
                                                        break;
                                                    case 'VALIDATION FAILED':
                                                        msg = '미션 종류, 시작 시간, 사용할 맵, 사용할 애드온 중 어느 하나에 빈칸이 있습니다.'
                                                        break;
                                                    case 'DATE OLD':
                                                        msg = '미션 시간은 지난 날짜로 설정할 수 없습니다.';
                                                        break;
                                                    case 'DATE UNAVAILABLE':
                                                        msg = '기존 등록된 미션 시간과 겹칩니다.';
                                                        break;
                                                    case 'PERMISSION ERROR':
                                                        msg = '권한이 없습니다.';
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
                                        this.data.create.lock = false;
                                    }

                                    if (!this.data.create.lock) {
                                        this.data.create.lock = true;
                                        this.post(this.data.create.url, this.data.create.body, success, error, complete);
                                    }
                                },
                                post(url, body, success, error, complete) {
                                    window.axios.post(url, body).then(success).catch(error).then(complete);
                                }
                            }));
                        });

                        window.addEventListener('load', function(){
                            ClassicEditor.create(document.querySelector('#editor'), {
                                viewportTopOffset : 50,
                                simpleUpload: {
                                    uploadUrl: '{{route('file.upload.ckeditor.api')}}',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                },
                            }).then(e => {
                                window.global.editor = e;
                            }).catch(e => {
                                console.error(e.stack);
                            });
                        });
                    </script>
                </div>

            </div>
        </div>
    </x-section.basic>
</x-sub-page>
