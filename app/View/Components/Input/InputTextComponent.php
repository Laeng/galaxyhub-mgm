<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

abstract class InputTextComponent extends Component
{
    public string $type;
    public string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($type = 'text', $class = '')
    {
        $this->type = $type;
        $this->class = $class;
    }
}
