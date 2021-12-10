<?php

namespace App\View\Components\Button\Filled;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class XlBlue extends Component
{
    public string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '')
    {
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.button.filled.xl-blue');
    }
}
