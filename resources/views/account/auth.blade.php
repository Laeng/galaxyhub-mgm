@push('og')
    <meta property="og:title" content="로그인" />
    <meta property="og:description" content="MGM 아르마 클랜 회원분들을 위한 공간, MGM 라운지 입니다." />
@endpush

<x-layout.layout>
    <x-section.base class="h-screen">
        <div class="h-full flex justify-center items-center">
            <!-- Row -->
            <div class="w-full lg:w-11/12 xl:w-4/5 flex flex-col lg:flex-row">
                <div class="w-full h-44 lg:h-auto bg-gray-400 block lg:w-1/2 bg-cover bg-center rounded-t-lg lg:rounded-l-lg lg:rounded-tr-none" style="background-image: url('https://cdn.discordapp.com/attachments/229099609140494336/834692945776869376/20210422134727_1.jpg')">

                </div>
                <div class="w-full lg:w-1/2 lg:h-[32rem] bg-white p-5 rounded-b-lg lg:rounded-tr-lg lg:rounded-bl-none">
                    <div class="flex flex-col h-full">
                        <div class="flex-grow">
                            <div class="flex items-center justify-center h-full">
                                <div>
                                    <h3 class="pt-4 font-bold text-2xl text-blue-900 text-center">MGM Lounge</h3>
                                    <p class="p-4 text-center">MGM 라운지는 MGM 아르마 클랜 회원님을 위한 공간입니다. <span class="font-bold">STEAM</span>&reg; 계정으로 로그인 하실 수 있습니다.</p>
                                    <div class="flex justify-center pt-4 pb-8 lg:pb-0">
                                        <a href="{{ $steam }}">
                                            <img src="{{asset('image/logo/steam.png')}}" alt="스팀 로그인 버튼"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-6 border-t" />
                        <div class="text-center">
                            <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="./register.html">
                                돌아가기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-section.base>
</x-layout.layout>

