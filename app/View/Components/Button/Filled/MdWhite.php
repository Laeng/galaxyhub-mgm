<?php

namespace App\View\Components\Button\Filled;

use App\View\Components\Button\Skeleton;
use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class MdWhite extends Skeleton
{
    public function render(): View
    {
        return view('components.button.filled.md-white');
    }
}
