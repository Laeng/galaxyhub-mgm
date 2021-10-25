<?php

namespace App\View\Components\Section;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Base extends Component
{
    public string $parentClass;
    public string $parentStyle;
    public string $class;
    public string $style;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $parentClass = "", string $parentStyle = "", string $class = "", string $style = "")
    {
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
        return view('components.section.base');
    }
}
