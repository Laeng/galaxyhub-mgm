<?php

namespace App\View\Components\Alert;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Danger extends Component
{
    public string $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = "")
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.alert.danger');
    }
}
