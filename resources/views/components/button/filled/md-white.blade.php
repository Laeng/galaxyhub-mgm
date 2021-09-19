<button {{ $attributes->except('class') }} class="inline-flex items-center justify-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-md shadow-sm text-black bg-white hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-transparent focus:ring-gray-400 {{ $class }}">
    {{ $slot }}
</button>
