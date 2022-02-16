<label class="block">
    <p class="leading-6 font-medium text-gray-900 dark:text-gray-100 mb-0.5">{!! $question->title !!} {!! in_array('required', $question->rules) ? '<span class="text-red-600 text-base">*</span>' : '' !!}</p>
    @if (is_null($answer))
        <p class="text-sm text-gray-500 dark:text-gray-300 mb-2">{!! $question->content !!}</p>
        <input type="text" name="{{ $question->key }}" id="{{ $question->key }}" value="{{ old($question->key) }}" {{ in_array('required', $question->rules) ? 'required' : '' }}
        class="block w-full rounded-md dark:bg-gray-900 @error($question->key) border-red-600 @else border-gray-300 dark:border-gray-800 @enderror shadow-sm focus:ring-blue-500">
        @error($question->key)
            <p class="text-sm text-red-700 mt-1">{{ $message }}</p>
        @enderror
    @else
        <p class="text-sm">{{ $answer }}</p>
    @endif
</label>
