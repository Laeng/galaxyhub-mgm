<label class="block">
    <p class="text-lg leading-6 font-medium text-gray-900 mb-0.5">{!! $question->title !!}</p>
    <p class="text-sm text-gray-500 mb-2">{!! $question->content !!}</p>
    <input type="text" name="{{ $question->key }}" id="{{ $question->key }}" value="{{ old($question->key) }}" {{ in_array('required', $question->rules) ? 'required' : '' }}
           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
</label>
