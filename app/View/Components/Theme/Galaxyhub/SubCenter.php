<?php

namespace App\View\Components\Theme\Galaxyhub;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubCenter extends Component
{
    public string $title;
    public string $description;
    public string $websiteName;
    public string $alignContent;

    public function __construct(string $title = '', string $description = '', string $websiteName = 'MGM Lounge', string $alignContent = 'center')
    {
        $this->title = $title;
        $this->description = $description;
        $this->websiteName = $websiteName;
        $this->alignContent = $alignContent;
    }

    public function render(): View
    {
        return view('components.theme.galaxyhub.sub-center');
    }
}
