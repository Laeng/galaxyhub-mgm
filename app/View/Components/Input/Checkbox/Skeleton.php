<?php

namespace App\View\Components\Input\Checkbox;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class Skeleton extends Component
{
    public string $type;
    public string $class;
    public bool $checked;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($type = 'text', $class = '', $checked = false)
    {
        $this->type = $type;
        $this->class = $class;
        $this->checked = $checked;
    }

    public abstract function render(): View;
}
