<select {{ $attributes->except('class') }} class="shadow-sm focus:ring-0 focus:border-1 focus:border-gray-200 block w-full text-sm border-gray-200 rounded-md {{ $class }}">
    {{ $slot }}
</select>
