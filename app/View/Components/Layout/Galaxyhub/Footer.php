<?php

namespace App\View\Components\Layout\Galaxyhub;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Footer extends Component
{
    public string $parentClass;
    public string $class;
    public string $footerTextClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($parentClass = '', $class = '', $footerTextClass = '')
    {
        $this->parentClass = $parentClass;
        $this->class = $class;
        $this->footerTextClass = $footerTextClass;
    }

    public function render(): View
    {
        return view('components.layout.galaxyhub.footer');
    }
}
