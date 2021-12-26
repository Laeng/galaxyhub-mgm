<button {{ $attributes->except('class') }} class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-black bg-white hover:bg-gray-200 focus:outline-none whitespace-nowrap {{ $class }}">
    {{ $slot }}
</button>
