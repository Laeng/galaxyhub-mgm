<?php

namespace App\View\Components\Memo\Galaxyhub;

use Illuminate\View\Component;

class Basics extends Component
{
    public int $userId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.memo.galaxyhub.basics');
    }
}
