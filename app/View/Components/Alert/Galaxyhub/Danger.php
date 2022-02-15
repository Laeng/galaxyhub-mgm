<?php

namespace App\View\Components\Alert\Galaxyhub;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Danger extends Component
{
    public string $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(): View
    {
        return view('components.alert.galaxyhub.danger');
    }
}
