<button {{ $attributes->except('class') }} class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none {{ $class }}">
    {{ $slot }}
</button>
