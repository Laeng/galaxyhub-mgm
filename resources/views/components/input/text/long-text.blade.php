<label>
    <textarea {{ $attributes->except(['class']) }} class="w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-800 focus:ring-blue-500 shadow-sm {{ $class }}">{{ $slot }}</textarea>
</label>
