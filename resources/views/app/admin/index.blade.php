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
                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path d="M48.02 448L48 64.13c0-8.836 7.164-16 16-16h160L224 128c0 17.67 14.33 32 32 32h79.1v94.18L384 206.5V138.6c0-16.98-6.742-33.26-18.74-45.26l-74.63-74.64C278.6 6.742 262.3 0 245.4 0H63.93C28.58 0 0 28.65 0 64l.0065 384c0 35.34 28.58 64 63.93 64H320c29.65 0 54.53-20.52 61.71-48H64.02C55.18 464 48.02 456.8 48.02 448zM292.7 342.3C289.7 345.3 288 349.4 288 353.7V383.9L272.8 384c-4.125 0-8.125-2.5-10.12-6.5c-11.88-23.88-46.25-30.38-66-14.12l-13.88-41.63C179.5 311.9 170.4 305.3 160 305.3s-19.5 6.625-22.75 16.5L119 376.4C117.5 380.9 113.3 384 108.4 384H96c-8.875 0-16 7.125-16 16S87.13 416 96 416h12.38c18.62 0 35.13-11.88 41-29.5L160 354.6L176.9 405c2 6.25 7.5 10.5 14 11H192c5.999 0 11.62-3.375 14.25-8.875l7.749-15.38C216.8 386.3 221.9 385.6 224 385.6s7.25 .625 10.12 6.5C241.5 406.9 256.4 416 272.8 416h77.59c4.264 0 8.35-1.703 11.35-4.727l156.9-158l-67.88-67.88L292.7 342.3zM568.5 167.4L536.6 135.5c-9.875-10-26-10-36 0l-27.25 27.25l67.88 67.88l27.25-27.25C578.5 193.4 578.5 177.3 568.5 167.4z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.application.form') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">가입 신청서</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">가입 신청서 서식을 확인하고 수정합니다.</p>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div>
            <div class="my-2 lg:my-4">
                <h2 class="text-xl lg:text-2xl font-bold">미션</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">미션 설정 및 정보를 확인합니다.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">

                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M232 184H120C106.7 184 96 173.3 96 160C96 146.7 106.7 136 120 136H232C245.3 136 256 146.7 256 160C256 173.3 245.3 184 232 184zM328 232C341.3 232 352 242.7 352 256C352 269.3 341.3 280 328 280H120C106.7 280 96 269.3 96 256C96 242.7 106.7 232 120 232H328zM168 376H120C106.7 376 96 365.3 96 352C96 338.7 106.7 328 120 328H168C181.3 328 192 338.7 192 352C192 365.3 181.3 376 168 376zM384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM384 80H64C55.16 80 48 87.16 48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.mission.survey') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">미션 만족도 조사</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">미션 만족도 조사 서식을 확인하고 수정합니다.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="my-2 lg:my-4">
                <h2 class="text-xl lg:text-2xl font-bold">업데이터</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">MGM 업데이터 설정 및 정보를 확인합니다.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">

                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" viewBox="0 0 640 512">
                            <path d="M592 288H576V212.7c0-41.84-30.03-80.04-71.66-84.27c-2.805-.2852-5.59-.4229-8.336-.4229C451.9 127.1 416 163.9 416 208V288h-16C373.6 288 352 309.6 352 336v128c0 26.4 21.6 48 48 48h192c26.4 0 48-21.6 48-48v-128C640 309.6 618.4 288 592 288zM496 432c-17.62 0-32-14.38-32-32s14.38-32 32-32s32 14.38 32 32S513.6 432 496 432zM528 288h-64V208c0-17.62 14.38-32 32-32s32 14.38 32 32V288zM224 256c70.69 0 128-57.31 128-128c0-70.69-57.31-128-128-128S96 57.31 96 128C96 198.7 153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48zM320 464c0 18.08 6.256 34.59 16.41 48H32c-17.67 0-32-14.33-32-32c0-97.2 78.8-176 176-176h96c18.09 0 35.54 2.748 51.97 7.818C321.5 319.5 320 327.5 320 336v25.52C305.1 355.5 288.1 352 272 352h-96c-65.16 0-119.1 48.95-127 112H320z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.updater.users') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">업데이터 인증 현황</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">MGM 업데이터 사용자 인증 현황을 확인합니다.</p>
                        </a>
                    </div>
                </div>
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
                        <svg  class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM57.71 192.1L67.07 209.4C75.36 223.9 88.99 234.6 105.1 239.2L162.1 255.7C180.2 260.6 192 276.3 192 294.2V334.1C192 345.1 198.2 355.1 208 359.1C217.8 364.9 224 374.9 224 385.9V424.9C224 440.5 238.9 451.7 253.9 447.4C270.1 442.8 282.5 429.1 286.6 413.7L289.4 402.5C293.6 385.6 304.6 371.1 319.7 362.4L327.8 357.8C342.8 349.3 352 333.4 352 316.1V307.9C352 295.1 346.9 282.9 337.9 273.9L334.1 270.1C325.1 261.1 312.8 255.1 300.1 255.1H256.1C245.9 255.1 234.9 253.1 225.2 247.6L190.7 227.8C186.4 225.4 183.1 221.4 181.6 216.7C178.4 207.1 182.7 196.7 191.7 192.1L197.7 189.2C204.3 185.9 211.9 185.3 218.1 187.7L242.2 195.4C250.3 198.1 259.3 195 264.1 187.9C268.8 180.8 268.3 171.5 262.9 165L249.3 148.8C239.3 136.8 239.4 119.3 249.6 107.5L265.3 89.12C274.1 78.85 275.5 64.16 268.8 52.42L266.4 48.26C262.1 48.09 259.5 48 256 48C163.1 48 84.4 108.9 57.71 192.1L57.71 192.1zM437.6 154.5L412 164.8C396.3 171.1 388.2 188.5 393.5 204.6L410.4 255.3C413.9 265.7 422.4 273.6 433 276.3L462.2 283.5C463.4 274.5 464 265.3 464 256C464 219.2 454.4 184.6 437.6 154.5H437.6z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.statistic.map') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">맵 통계</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">사용된 맵에 대한 통계를 조회합니다.</p>
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
                <h2 class="text-xl lg:text-2xl font-bold">예산</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">운영에 대한 필요 예산을 예측하고 확인합니다.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">

                <div class="relative rounded-lg border border-gray-300 dark:border-gray-800 bg-white dark:bg-gray-900 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-700">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-gray-500 dark:text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path d="M304 16.58C304 7.555 310.1 0 320 0C443.7 0 544 100.3 544 224C544 233 536.4 240 527.4 240H304V16.58zM32 272C32 150.7 122.1 50.34 238.1 34.25C248.2 32.99 256 40.36 256 49.61V288L412.5 444.5C419.2 451.2 418.7 462.2 411 467.7C371.8 495.6 323.8 512 272 512C139.5 512 32 404.6 32 272zM558.4 288C567.6 288 575 295.8 573.8 305C566.1 360.9 539.1 410.6 499.9 447.3C493.9 452.1 484.5 452.5 478.7 446.7L320 288H558.4z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.budget.live') }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">실시간 비용</p>
                            <p class="text-sm text-gray-500  dark:text-gray-300 truncate">이용 중인 서비스에 대한 실시간 비용을 확인합니다.</p>
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
