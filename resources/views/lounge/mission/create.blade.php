<x-sub-page website-name="MGM Lounge" title="{{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{$title}}</h1>

                <div class="">
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                            <div class="">
                                <label for="type" class="block text-sm font-medium text-gray-700">
                                    미션 분류
                                </label>
                                <div class="mt-1">
                                    <select id="type" name="type" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option>아르마의 밤</option>
                                        <option>미션</option>
                                        <option>논미메</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pt-2 md:py-0">
                                <label class="block text-sm font-medium text-gray-700">
                                    시작 시간
                                </label>
                                <div class="mt-1 grid grid-cols-2 gap-x-2">
                                    <input type="date" class="shadow-sm focus:ring-blue-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <input type="time" class="shadow-sm focus:ring-blue-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4">
                            <div class="">
                                <label for="type" class="block text-sm font-medium text-gray-700">
                                    사용할 맵
                                </label>
                                <div class="mt-1">
                                    <select id="type" name="type" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option>알티스</option>
                                        <option>스트라티스</option>
                                        <option>타노아</option>
                                        <option>체르나러스</option>
                                        <option>자가바드</option>
                                        <option>팔루자</option>
                                        <option>기타</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-2 md:py-0 md:col-span-2">
                                <label for="type" class="block text-sm font-medium text-gray-700">
                                    사용할 애드온
                                </label>
                                <div class="h-11 flex justify-between items-center space-x-2">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="RHS" aria-describedby="offers-description" name="RHS" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="RHS" class="font-medium text-gray-700">RHS</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="F1" aria-describedby="offers-description" name="F1" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="F1" class="font-medium text-gray-700">F1</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="F2" aria-describedby="offers-description" name="F2" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="F2" class="font-medium text-gray-700">F2</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="WAR" aria-describedby="offers-description" name="WAR" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="WAR" class="font-medium text-gray-700">WAR</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="MAPS" aria-describedby="offers-description" name="MAPS" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="MAPS" class="font-medium text-gray-700">MAPS</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="MAPS2" aria-describedby="offers-description" name="MAPS2" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="MAPS2" class="font-medium text-gray-700">MAPS2</label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="NAVY" aria-describedby="offers-description" name="NAVY" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="NAVY" class="font-medium text-gray-700">NAVY</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="prose max-w-full">
                            <label for="info" class="block text-sm font-medium text-gray-700 pb-1">
                                미션 정보
                            </label>
                            <textarea id="info" name="info" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md" placeholder="미션 정보 입력"></textarea>

                            <script>
                                window.addEventListener('load', function(){
                                    window.ckeditor.create(document.querySelector('#info'), {
                                        viewportTopOffset : 50,
                                        toolbar: ['heading', '|', 'bold', 'italic', 'link',  'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote'],
                                        language: 'ko'
                                    });
                                });

                            </script>
                        </div>

                        <div>
                            <div class="flex justify-center space-x-2">
                                <x-button.filled.md-blue type="button">
                                    등록
                                </x-button.filled.md-blue>
                                <x-button.filled.md-white type="button">
                                    취소
                                </x-button.filled.md-white>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </x-section.basic>
</x-sub-page>
