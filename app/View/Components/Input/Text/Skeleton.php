<?php

namespace App\View\Components\Input\Text;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class Skeleton extends Component
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

    public abstract function render(): View;
}
