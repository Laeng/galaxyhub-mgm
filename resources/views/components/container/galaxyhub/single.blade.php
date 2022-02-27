<div class="relative h-full">
    <div class="h-full grid grid-cols-1" style="align-content: {{ $alignContent }};">
        <div class="max-w-7xl mx-auto py-4 px-4 {{ $class }}" style="{{ $style }}">
            {{$slot}}
        </div>
    </div>
</div>
