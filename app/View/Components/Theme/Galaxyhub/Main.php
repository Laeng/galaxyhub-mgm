<?php

namespace App\View\Components\Theme\Galaxyhub;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Main extends Component
{
    public string $title;
    public string $description;
    public string $websiteName;
    public string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = '', $description = '', $websiteName = '', $class = '')
    {
        $this->title = $title;
        $this->description = $description;
        $this->websiteName = $websiteName;
        $this->class = $class;
    }

    public function render(): View
    {
        return view('components.theme.galaxyhub.sub');
    }
}
