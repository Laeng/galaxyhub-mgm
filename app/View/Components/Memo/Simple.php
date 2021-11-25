<?php

namespace App\View\Components\Memo;

use Illuminate\View\Component;

class Simple extends Component
{
    public int $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->id = $userId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.memo.simple');
    }
}
