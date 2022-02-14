<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

abstract class InputSelectComponent extends Component
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
}
