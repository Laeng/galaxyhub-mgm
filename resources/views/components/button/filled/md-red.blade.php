<button {{ $attributes->except('class') }} class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none whitespace-nowrap {{ $class }}">
    {{ $slot }}
</button>
