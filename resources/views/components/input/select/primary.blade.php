<select {{ $attributes->except('class') }} class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full text-sm border-gray-300 rounded-md {{ $class }}">
    {{ $slot }}
</select>
