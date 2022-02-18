<button {{ $attributes->except('class') }} class="inline-flex items-center justify-center px-4 py-2 border border-gray-200 dark:border-gray-800 text-sm font-medium rounded-md shadow-sm text-black dark:text-gray-100 bg-white dark:bg-transparent hover:bg-gray-200 dark:hover:bg-gray-800 focus:outline-none whitespace-nowrap {{ $class }}">
    {{ $slot }}
</button>
