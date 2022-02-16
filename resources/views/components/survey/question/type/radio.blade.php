<fieldset>
    <legend class="leading-6 font-medium text-gray-900 dark:text-gray-100 mb-0.5">{!! $question->title !!} {!! in_array('required', $question->rules) ? '<span class="text-red-600 text-base">*</span>' : '' !!}</legend>
    @if (is_null($answer))
        <p class="text-sm text-gray-500 dark:text-gray-300 mb-2">{!! $question->content !!}</p>
        <div class="flex flex-col lg:flex-row space-y-2 lg:space-y-0 lg:space-x-4">
            @foreach($question->options as $option)
                <label class="inline-flex items-center">
                    <input type="radio" name="{{ $question->key }}" id="{{ "{$question->key}-{$loop->index}" }}" value="{{ $option }}" @if(old($question->key)) checked @endif {{ in_array('required', $question->rules) ? 'required' : '' }}
                    class="rounded-full dark:bg-gray-900 @error($question->key) border-red-600 @else border-gray-300 dark:border-gray-800 @enderror text-blue-600 shadow-sm focus:ring-blue-500 focus:ring focus:ring-offset-0">
                    <span class="ml-2">{{ $option }}</span>
                </label>
            @endforeach
        </div>
        @error($question->key)
        <p class="text-sm text-red-700 mt-1">{{ $message }}</p>
        @enderror
    @else
        <p class="text-sm">{{ $answer }}</p>
    @endif
</fieldset>
