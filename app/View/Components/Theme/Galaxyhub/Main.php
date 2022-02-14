<?php

namespace App\View\Components\Theme\Galaxyhub;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Main extends Component
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

    public function render(): View
    {
        return view('components.theme.galaxyhub.main');
    }
}
