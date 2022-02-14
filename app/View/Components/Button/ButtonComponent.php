<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;

abstract class ButtonComponent extends Component
{
    public string $class;

    public function __construct(string $class = '')
    {
        $this->class = $class;
    }
}
