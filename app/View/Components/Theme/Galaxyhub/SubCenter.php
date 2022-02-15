<?php

namespace App\View\Components\Theme\Galaxyhub;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubCenter extends Component
{
    public string $title;
    public string $description;
    public string $websiteName;

    public function __construct(string $title = '', string $description = '', string $websiteName = 'MGM Lounge')
    {
        $this->title = $title;
        $this->description = $description;
        $this->websiteName = $websiteName;
    }

    public function render(): View
    {
        return view('components.theme.galaxyhub.sub-center');
    }
}
