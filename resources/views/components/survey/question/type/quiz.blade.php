@php
    $options = $question->options;
    $realAnswer = array_pop($options);
    shuffle($options)
@endphp

<fieldset>
    @if (is_null($answer))
        <legend class="leading-6 font-medium text-gray-900 dark:text-gray-100 mb-0.5">{!! $question->title !!} {!! in_array('required', $question->rules) ? '<span class="text-red-600 text-base">*</span>' : '' !!}</legend>

        @if(!is_null($question->content) && $question->content !== '')
            <div class="p-4 rounded-md bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-800 my-2">
                <div class="text-sm text-gray-700 dark:text-gray-200">
                    {!! $question->content !!}
                </div>
            </div>
        @endif

        <div class="flex flex-col space-y-1 mt-4">
            @foreach($options as $option)
                <label class="inline-flex items-start">
                    <input type="radio" name="{{ $question->key }}" id="{{ "{$question->key}-{$loop->index}" }}" value="{{ $option }}" @if(old($question->key)) checked @endif {{ in_array('required', $question->rules) ? 'required' : '' }}
                    class="rounded-full dark:bg-gray-900 @error($question->key) border-red-600 @else border-gray-300 @enderror text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50 mt-1">
                    <span class="ml-2">{{ $option }}</span>
                </label>
            @endforeach
        </div>
        @error($question->key)
        <p class="text-sm text-red-700 mt-1">{{ $message }}</p>
        @enderror

    @else
        <legend class="relative leading-6 font-medium text-gray-900 dark:text-gray-100 mb-0.5">
            {!! $question->title !!} {!! in_array('required', $question->rules) ? '<span class="text-red-600 text-base">*</span>' : '' !!}

            <div class="text-red-500">
                @if($realAnswer === $answer)
                    <svg class="absolute -top-[0.55rem] -left-[0.95rem] h-10 w-10 mix-blend-multiply" style="-webkit-mask-image: url('{{ asset('images/rubber.png') }}'); -webkit-mask-repeat:repeat; -webkit-mask-position: {{mt_rand(0, 64)}}px {{mt_rand(0, 64)}}px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"></path>
                    </svg>
                @else
                    <svg class="absolute -top-[0.55rem] -left-[0.95rem] h-10 w-10 mix-blend-multiply" style="-webkit-mask-image: url('{{ asset('images/rubber.png') }}'); -webkit-mask-repeat:repeat; -webkit-mask-position: {{mt_rand(0, 64)}}px {{mt_rand(0, 64)}}px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path fill="currentColor" d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"></path>
                    </svg>
                @endif
            </div>
        </legend>

        @if(!is_null($question->content) && $question->content !== '')
            <div class="p-4 rounded-md bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-800 my-2">
                <div class="text-sm text-gray-700 dark:text-gray-200">
                    {!! $question->content !!}
                </div>
            </div>
        @endif
        <div class="flex flex-col space-y-1 mt-4">
            @foreach($options as $option)
                <label class="inline-flex items-start">
                    <input type="radio" name="{{ $question->key }}" @if($option === $answer) checked @endif disabled
                           class="rounded-full dark:bg-gray-900 border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50 mt-1">
                    <span class="ml-2 @if($realAnswer !== $option) line-through text-red-600 @else font-bold  @endif">{{ $option }}</span>
                </label>
            @endforeach
        </div>
    @endif
</fieldset>
