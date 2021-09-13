<?php

namespace App\View\Components\Section;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Basic extends Component
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
    public function __construct($grandParentClass = "", $grandParentStyle = "", $parentClass = "", $parentStyle = "", $class = "", $style = "")
    {
        $this->grandParentClass = $grandParentClass;
        $this->grandParentStyle = $grandParentStyle;
        $this->parentClass = $parentClass;
        $this->parentStyle = $parentStyle;
        $this->class = $class;
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.section.basic');
    }
}
