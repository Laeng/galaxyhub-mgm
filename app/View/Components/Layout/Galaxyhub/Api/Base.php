<?php

namespace App\View\Components\Layout\Galaxyhub\Api;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Base extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render():View
    {
        return view('components.layout.galaxyhub.api.base');
    }
}
