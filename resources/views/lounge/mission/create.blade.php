<x-sub-page website-name="MGM Lounge" title="{{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{$title}}</h1>

                <div class="" x-data="mission_create()">
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                            <div class="">
                                <label for="type" class="block text-sm font-medium text-gray-700">
                                    미션 종류
                                </label>
                                <div class="mt-1">
                                    <select id="type" name="type" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" x-model="data.create.body.type" required>
                                        <option value="">종류 선택</option>
                                        <option value="0">아르마의 밤</option>
                                        <option value="1">일반 미션</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pt-2 md:py-0">
                                <label class="block text-sm font-medium text-gray-700">
                                    시작 시간
                                </label>
                                <div class="mt-1 grid grid-cols-2 gap-x-2">
                                    <input type="date" name="date" class="shadow-sm focus:ring-blue-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" x-model="data.create.body.date" required>
                                    <input type="time" name="time" class="shadow-sm focus:ring-blue-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" x-model="data.create.body.time" step="60" required>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4">
                            <div class="">
                                <label for="map" class="block text-sm font-medium text-gray-700">
                                    사용할 맵
                                </label>
                                <div class="mt-1">
                                    <select id="type" name="map" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" x-model="data.create.body.map" required>
                                        <option value="">맵 선택</option>
                                        <option value="알티스">알티스</option>
                                        <option value="스트라티스">스트라티스</option>
                                        <option value="타노아">타노아</option>
                                        <option value="체르나러스">체르나러스</option>
                                        <option value="자가바드">자가바드</option>
                                        <option value="팔루자">팔루자</option>
                                        <option value="기타">기타</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-2 md:py-0 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    사용할 애드온
                                </label>
                                <div class="h-11 flex justify-between items-center flex-wrap">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="RHS" aria-describedby="offers-description" name="addons[]" value="RHS" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.addons">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="RHS" class="font-medium text-gray-700">RHS</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="F1" aria-describedby="offers-description" name="addons[]" value="F1" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.addons">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="F1" class="font-medium text-gray-700">F1</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="F2" aria-describedby="offers-description" name="addons[]" value="F2" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.addons">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="F2" class="font-medium text-gray-700">F2</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="WAR" aria-describedby="offers-description" name="addons[]" value="WAR" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.addons">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="WAR" class="font-medium text-gray-700">WAR</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="MAPS" aria-describedby="offers-description" name="addons[]" value="MAPS" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.addons">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="MAPS" class="font-medium text-gray-700">MAPS</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="MAPS2" aria-describedby="offers-description" name="addons[]" value="MAPS2" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.addons">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="MAPS2" class="font-medium text-gray-700">MAPS2</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="NAVY" aria-describedby="offers-description" name="addons[]" value="NAVY" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.addons">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="NAVY" class="font-medium text-gray-700">NAVY</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="etc" aria-describedby="offers-description" name="addons[]" value="기타" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" x-model="data.create.body.addons">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="etc" class="font-medium text-gray-700">기타</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="prose max-w-full">
                            <label for="body" class="block text-sm font-medium text-gray-700 pb-1">
                                미션 정보
                            </label>
                            <textarea id="body" name="body" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md" placeholder="미션 정보 입력" x-model="data.create.body.body"></textarea>

                            <script>
                                window.addEventListener('load', function(){
                                    window.ckeditor.create(document.querySelector('#body'), {
                                        viewportTopOffset : 50,
                                        toolbar: ['heading', '|', 'bold', 'italic', 'link',  'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote'],
                                        language: 'ko'
                                    }).then(e => {
                                        window.global.editor = e;
                                    }).catch(e => {
                                        console.error(e.stack);
                                    });
                                });

                            </script>
                        </div>

                        <div class="flex justify-start">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="tardy" aria-describedby="offers-description" name="tardy" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" @click="data.create.body.tardy = !data.create.body.tardy">
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
                                <x-button.filled.md-white type="button" onClick="location.href='{{ back()->getTargetUrl() }}'">
                                    취소
                                </x-button.filled.md-white>
                            </div>
                        </div>

                    </div>

                    <script type="text/javascript">
                        function mission_create() {
                            return {
                                data: {
                                    create: {
                                        url: '{{route('mission.api.create')}}',
                                        body: {
                                            type: '',
                                            date: '',
                                            time: '',
                                            map: '',
                                            addons: [],
                                            body: '',
                                            tardy: true,
                                        },
                                        lock: false
                                    }
                                },
                                store() {
                                    let body = window.global.editor.getData();
                                    this.data.create.body.body = (body.length > 0) ? body : '미션 소개가 없습니다.';

                                    let success = (r) => {
                                        switch (r.data.description) {
                                            case 'OK':
                                                location.href = r.data.data.url;
                                                break;
                                            case 'DATE UNAVAILABLE':
                                                window.modal.alert('등록 실패', '기존 등록된 미션 시간과 겹칩니다.', (c) => {}, 'error');
                                                break;
                                        }
                                    }
                                    let error = (e) => {
                                        window.modal.alert('등록 실패', '데이터 처리 중 문제가 발생하였습니다.', (c) => {}, 'error');
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
                            }
                        }
                    </script>
                </div>

            </div>
        </div>
    </x-section.basic>
</x-sub-page>
