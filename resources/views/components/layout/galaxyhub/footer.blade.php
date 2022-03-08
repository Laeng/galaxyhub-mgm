<footer class="relative">
    <div class="{{ $parentClass }}">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl {{ $class }}">
            <div class="flex flex-col lg:flex-row lg:justify-between py-8 text-sm text-center lg:text-left text-gray-200">
                <p>
                    <span class="block sm:inline">&copy; 2008 멀티플레이 게임 매니지먼트</span>
                    <span class="block sm:inline">All rights reserved.</span>
                </p>
                <div class="space-x-2 mt-2 lg:mt-0">
                    <a class="link-gray-300" href="{{ route('app.rules') }}">이용약관</a>
                    <a class="link-gray-300" href="{{ route('app.privacy') }}">개인정보취급방침</a>
                </div>
            </div>
        </div>
    </div>
</footer>
