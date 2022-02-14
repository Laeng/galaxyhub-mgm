<section class="relative h-full">
    <div class="h-full grid content-center {{ $grandParentClass }}" style="{{ $grandParentStyle }}">
        <div class="max-w-7xl mx-auto py-4 px-4 {{ $parentClass }}" style="{{ $parentStyle }}">
            <div class="{{$class}}" style="{{$style}}">
                {{$slot}}
            </div>
        </div>
    </div>
</section>
