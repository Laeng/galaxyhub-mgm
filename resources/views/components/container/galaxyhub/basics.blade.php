<section class="relative">
    <div class="{{ $grandParentClass }}" style="{{ $grandParentStyle }}">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 {{ $parentClass }}" style="{{ $parentStyle }}">
            <div class="{{$class}}" style="{{$style}}">
                {{$slot}}
            </div>
        </div>
    </div>
</section>
