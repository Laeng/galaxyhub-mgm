<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Footer extends Component
{
    public string $parentClass;
    public string $class;
    public string $footerTextClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($parentClass = "", $class = "", $footerTextClass = "")
    {
        $this->parentClass = $parentClass;
        $this->class = $class;
        $this->footerTextClass = $footerTextClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.footer');
    }
}
