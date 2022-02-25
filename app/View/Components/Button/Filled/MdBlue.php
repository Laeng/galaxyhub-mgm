<?php

namespace App\View\Components\Button\Filled;

use App\View\Components\Button\Skeleton;
use \Illuminate\Contracts\View\View;

class MdBlue extends Skeleton
{
    public function render(): View
    {
        return view('components.button.filled.md-blue');
    }
}
