<?php

namespace App\View\Components\Input\Select;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Primary extends Component
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
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.input.select.primary');
    }
}
