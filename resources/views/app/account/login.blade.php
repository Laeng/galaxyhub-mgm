<x-theme.galaxyhub.sub website-name="MGM Lounge" title="로그인" description="MGM Lounge 로그인">
    <x-container.galaxyhub.single align-content="center">
        <div class="w-full flex flex-col lg:flex-row" x-data="login">
            <div class="w-full h-44 lg:h-auto bg-gray-400 block lg:w-1/2 bg-cover bg-center rounded-t-lg lg:rounded-l-lg lg:rounded-tr-none"
                 style="background-image: url('{{ asset('images/background/login.jpg') }}')">
            </div>
            <div class="w-full lg:w-1/2 lg:h-[32rem] bg-white dark:bg-gray-600/10 dark:border dark:border-gray-600 p-5 rounded-b-lg lg:rounded-tr-lg lg:rounded-bl-none">
                <div class="flex flex-col h-full">
                    <div class="grow">
                        <div class="flex items-center justify-center h-full">
                            <div>
                                <h3 class="pt-4 font-bold text-2xl text-indigo-600 text-center">MGM Lounge</h3>
                                <p class="p-4 text-center">
                                    MGM 라운지는 MGM 아르마 클랜 회원님을 위한 공간입니다.
                                    <span class="font-bold">STEAM</span>&reg; 계정으로 로그인 하실 수 있습니다.
                                </p>
                                <div class="flex justify-center pt-4 pb-8 lg:pb-0">
                                    <div class="space-y-4 md:space-y-2">
                                        <button @click="login('steam')" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-black hover:bg-gray-900 focus:outline-none whitespace-nowrap">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                                <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.79 52.79 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3.1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"/>
                                            </svg>
                                            <p>STEAM&reg; 아이디로 로그인</p>
                                        </button>
                                        <!--
                                        <div class="flex justify-center">
                                            <div class="flex items-center">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" id="remember" class="focus:ring-indigo-500 focus:ring focus:ring-offset-0 h-4 w-4 text-indigo-600 border-gray-300 rounded" x-model="data.ui.remember">
                                                </div>
                                                <div class="ml-1 text-sm">
                                                    <label for="remember" class="font-medium text-gray-700">자동 로그인</label>
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-6 border-t dark:border-gray-600" />
                    <div class="text-center">
                        <a class="inline-block text-sm text-blue-600 align-baseline hover:text-blue-800 dark:hover:text-blue-400" href="{{ route('welcome') }}">
                            돌아가기
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            document.addEventListener('alpine:init', () => {
                window.alpine.data('login', () => ({
                    interval: {
                        load: -1,
                    },
                    data: {
                        ui: {
                            remember: false
                        },
                    },
                    login(name) {
                        let url = '';

                        switch (name) {
                            case 'steam':
                                url = '{{ route('auth.login.provider', 'steam') }}'
                                break;
                            default:
                                break;
                        }

                        location.href = url;
                    },
                    init() {},
                    post(url, body, success, error, complete) {
                        window.axios.post(url, body).then(success).catch(error).then(complete);
                    }
                }));
            });
        </script>
    </x-container.galaxyhub.single>
</x-theme.galaxyhub.sub>
