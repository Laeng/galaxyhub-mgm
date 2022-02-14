<?php

namespace App\View\Components\Button\Filled;

use App\View\Components\Button\ButtonComponent;
use \Illuminate\Contracts\View\View;

class MdBlue extends ButtonComponent
{
    public function render(): View|\Closure|string
    {
        return view('components.button.filled.md-blue');
    }
}
