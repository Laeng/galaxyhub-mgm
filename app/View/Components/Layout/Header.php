<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;


class Header extends Component
{
    public string $parentClass;
    public string $class;
    public string $logoHexCode;
    public string $logoTextClass;
    public string $menuTextClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($parentClass = "", $class = "", $logoHexCode = "#000", $logoTextClass = "", $menuTextClass = "text-gray-700")
    {
        $this->parentClass = $parentClass;
        $this->class = $class;
        $this->logoHexCode = $logoHexCode;
        $this->logoTextClass = $logoTextClass;
        $this->menuTextClass = $menuTextClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.header');
    }
}
