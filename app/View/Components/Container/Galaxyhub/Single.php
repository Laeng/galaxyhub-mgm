<?php

namespace App\View\Components\Container\Galaxyhub;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Single extends Component
{
    public string $grandParentClass;
    public string $grandParentStyle;
    public string $parentClass;
    public string $parentStyle;
    public string $class;
    public string $style;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $grandParentClass = '', string $grandParentStyle = '', string $parentClass = '', string $parentStyle = '', string $class = '', string $style = '')
    {
        $this->grandParentClass = $grandParentClass;
        $this->grandParentStyle = $grandParentStyle;
        $this->parentClass = $parentClass;
        $this->parentStyle = $parentStyle;
        $this->class = $class;
        $this->style = $style;
    }

    public function render():View
    {
        return view('components.container.galaxyhub.single');
    }
}
