<label class="flex space-x-1 items-center">
    <input {{ $attributes->except(['class', 'type']) }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-800 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring focus:ring-offset-0 {{ $class }}" type="{{ $type }}" @if($checked) checked @endif>
    {!! $slot !!}
</label>
