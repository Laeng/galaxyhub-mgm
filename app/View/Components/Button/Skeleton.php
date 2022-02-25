<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

abstract class Skeleton extends Component
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

    public abstract function render(): View;
}
