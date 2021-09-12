<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Layout extends Component
{
    public string $title;
    public string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = "", $class = "")
    {
        $this->title = $title;
        $this->class = $class;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.layout');
    }
}
