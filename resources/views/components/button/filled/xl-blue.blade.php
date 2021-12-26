<button {{ $attributes->except('class') }} class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none whitespace-nowrap {{ $class }}">
    {{ $slot }}
</button>
