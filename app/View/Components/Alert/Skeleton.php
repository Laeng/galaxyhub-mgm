<?php

namespace App\View\Components\Alert;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

abstract class Skeleton extends Component
{
    public string $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = '')
    {
        $this->title = $title;
    }

    public abstract function render(): View;
}
