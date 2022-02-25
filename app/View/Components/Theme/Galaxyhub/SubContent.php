<?php

namespace App\View\Components\Theme\Galaxyhub;

use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubContent extends Component
{
    public string $title;
    public string $description;
    public string $websiteName;
    public string $breadcrumbs;

    public function __construct(string $title = '', string $description = '', string $websiteName = 'MGM Lounge', string $breadcrumbs = '')
    {
        $this->title = $title;
        $this->description = $description;
        $this->websiteName = $websiteName;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render(): View
    {
        return view('components.theme.galaxyhub.sub-content');
    }
}
