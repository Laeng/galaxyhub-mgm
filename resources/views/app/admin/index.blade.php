<x-theme.galaxyhub.sub-content title="관리자 메뉴" description="MGM Lounge 관리자 메뉴" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin', '메인')">
    <div class="space-y-8">
        <div>
            <div class="my-2 lg:my-4">
                <h2 class="text-xl lg:text-2xl font-bold">회원</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">가입 신청자 및 회원을 관리합니다.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">

                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M319.9 320c57.41 0 103.1-46.56 103.1-104c0-57.44-46.54-104-103.1-104c-57.41 0-103.1 46.56-103.1 104C215.9 273.4 262.5 320 319.9 320zM319.9 160c30.85 0 55.96 25.12 55.96 56S350.7 272 319.9 272S263.9 246.9 263.9 216S289 160 319.9 160zM512 160c44.18 0 80-35.82 80-80S556.2 0 512 0c-44.18 0-80 35.82-80 80S467.8 160 512 160zM369.9 352H270.1C191.6 352 128 411.7 128 485.3C128 500.1 140.7 512 156.4 512h327.2C499.3 512 512 500.1 512 485.3C512 411.7 448.4 352 369.9 352zM178.1 464c10.47-36.76 47.36-64 91.14-64H369.9c43.77 0 80.66 27.24 91.14 64H178.1zM551.9 192h-61.84c-12.8 0-24.88 3.037-35.86 8.24C454.8 205.5 455.8 210.6 455.8 216c0 33.71-12.78 64.21-33.16 88h199.7C632.1 304 640 295.6 640 285.3C640 233.8 600.6 192 551.9 192zM183.9 216c0-5.449 .9824-10.63 1.609-15.91C174.6 194.1 162.6 192 149.9 192H88.08C39.44 192 0 233.8 0 285.3C0 295.6 7.887 304 17.62 304h199.5C196.7 280.2 183.9 249.7 183.9 216zM128 160c44.18 0 80-35.82 80-80S172.2 0 128 0C83.82 0 48 35.82 48 80S83.82 160 128 160z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.user.index') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">회원</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">가입한 회원을 조회 합니다.</p>
                        </a>
                    </div>
                </div>

                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path d="M208 256c35.35 0 64-28.65 64-64c0-35.35-28.65-64-64-64s-64 28.65-64 64C144 227.3 172.7 256 208 256zM464 232h-96c-13.25 0-24 10.75-24 24s10.75 24 24 24h96c13.25 0 24-10.75 24-24S477.3 232 464 232zM240 288h-64C131.8 288 96 323.8 96 368C96 376.8 103.2 384 112 384h192c8.836 0 16-7.164 16-16C320 323.8 284.2 288 240 288zM464 152h-96c-13.25 0-24 10.75-24 24s10.75 24 24 24h96c13.25 0 24-10.75 24-24S477.3 152 464 152zM512 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h448c35.35 0 64-28.65 64-64V96C576 60.65 547.3 32 512 32zM528 416c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V96c0-8.822 7.178-16 16-16h448c8.822 0 16 7.178 16 16V416z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.application.index') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">가입 신청자</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">가입 신청자를 조회합니다.</p>
                        </a>
                    </div>
                </div>


            </div>
        </div>

        <div>
            <div class="my-2 lg:my-4">
                <h2 class="text-xl lg:text-2xl font-bold">가입</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">가입 퀴즈 및 신청서 서식를 확인합니다.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">

                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M448 352V48C448 21.53 426.5 0 400 0h-320C35.89 0 0 35.88 0 80v352C0 476.1 35.89 512 80 512h344c13.25 0 24-10.75 24-24s-10.75-24-24-24H416v-66.95C434.6 390.4 448 372.8 448 352zM368 464h-288c-17.64 0-32-14.34-32-32s14.36-32 32-32h288V464zM400 352h-320c-11.38 0-22.2 2.375-32 6.688V80c0-17.66 14.36-32 32-32h320V352zM152 160h176C341.3 160 352 149.3 352 136S341.3 112 328 112h-176C138.8 112 128 122.8 128 136S138.8 160 152 160zM152 240h176C341.3 240 352 229.3 352 216S341.3 192 328 192h-176C138.8 192 128 202.8 128 216S138.8 240 152 240z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.application.quiz') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">가입 퀴즈</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">가입 퀴즈를 확인하고 수정합니다.</p>
                        </a>
                    </div>
                </div>
                <!--
                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="#" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">가입 신청서 서식</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">가입 신청서 서식을 확인하고 수정합니다.</p>
                        </a>
                    </div>
                </div>
                -->

            </div>
        </div>

        <div>
            <div class="my-2 lg:my-4">
                <h2 class="text-xl lg:text-2xl font-bold">통계</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">각종 통계를 조회합니다.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">

                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M448 0h-112c-17.67 0-32 14.33-32 32v48h32c17.67 0 32 14.33 32 32s-14.33 32-32 32h-32v64h64V224c0 17.67 14.33 32 32 32s32-14.33 32-32V208H480c17.67 0 32-14.33 32-32V64C512 28.65 483.3 0 448 0zM416 288h-48v32c0 17.67-14.33 32-32 32s-32-14.33-32-32V288H224v64H192c-17.67 0-32 14.33-32 32s14.33 32 32 32h32v48H72c-13.25 0-24-10.75-24-24V288H96V256c0-17.67 14.33-32 32-32s32 14.33 32 32v32h64V208h16c17.67 0 32-14.33 32-32s-14.33-32-32-32H224V96c0-17.67-14.33-32-32-32H64C28.65 64 0 92.65 0 128v312C0 479.8 32.24 512 72 512H384c35.35 0 64-28.65 64-64v-128C448 302.3 433.7 288 416 288z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.statistic.addon') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">애드온 통계</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">사용된 애드온에 대한 통계를 조회합니다.</p>
                        </a>
                    </div>
                </div>
                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M120 320h208C341.3 320 352 309.3 352 296S341.3 272 328 272h-208C106.8 272 96 282.8 96 296S106.8 320 120 320zM120 416h112c13.25 0 24-10.75 24-24s-10.75-24-24-24h-112C106.8 368 96 378.8 96 392S106.8 416 120 416zM120 224h208C341.3 224 352 213.3 352 200S341.3 176 328 176h-208C106.8 176 96 186.8 96 200S106.8 224 120 224zM384 0H64C28.65 0 0 28.65 0 64v384c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V64C448 28.65 419.3 0 384 0zM400 448c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V128h352V448z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.statistic.mission') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">미션 통계</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">미션에 대한 통계를 조회합니다.</p>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div>
            <div class="my-2 lg:my-4">
                <h2 class="text-xl lg:text-2xl font-bold">알림</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">네이버 카페 및 디스코드에 발행되는 미션 알림를 설정합니다.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">

                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M512 32H112C103.2 32 96 39.2 96 48L96.01 288c0 53.02 42.98 96 96 96h192C437 384 480 341 480 288h26.38c66.83 0 126.6-48.78 133-115.3C646.8 96.38 586.8 32 512 32zM432 288c0 26.4-21.6 48-48 48H192c-26.4 0-48-21.6-48-48V80h288V288zM512 240h-32v-160h32c44.13 0 80 35.88 80 80S556.1 240 512 240zM552 432H24C10.75 432 0 442.7 0 456C0 469.3 10.75 480 24 480h528c13.25 0 24-10.75 24-24C576 442.7 565.3 432 552 432z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.broadcast.naver.index') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">네이버 카페</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">네이버 카페 게시글 설정</p>
                        </a>
                    </div>
                </div>
                <!--
                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="#" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">디스코드</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">디스코드 설정</p>
                        </a>
                    </div>
                </div>
                -->

            </div>
        </div>
    </div>
</x-theme.galaxyhub.sub-content>
