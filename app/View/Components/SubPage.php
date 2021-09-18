<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;


class SubPage extends Component
{
    public string $title;
    public string $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = "", $description = "")
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.sub-page');
    }
}
