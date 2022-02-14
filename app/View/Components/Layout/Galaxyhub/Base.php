<?php

namespace App\View\Components\Layout\Galaxyhub;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Base extends Component
{
    public string $websiteName;
    public string $title;
    public string $description;
    public string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($websiteName = '', $title = '', $description = '', $class = '')
    {
        $this->websiteName = $websiteName === '' ? 'MGM Lounge' : $websiteName;
        $this->title = $title;
        $this->description = $description === '' ? '멀티플레이 게임 매니지먼트의 웹사이트 입니다. #아르마3 #스타시티즌 #MGM': $description;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render():View
    {
        return view('components.layout.galaxyhub.base');
    }
}
