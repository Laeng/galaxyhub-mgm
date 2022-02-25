<?php

namespace App\View\Components\breadcrumb\Galaxyhub;

use Illuminate\View\Component;

class Basics extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.breadcrumb.galaxyhub.basics');
    }
}
