<?php

namespace App\View\Components\Input\Text;

use Illuminate\Contracts\View\View;

class LongText extends Skeleton
{
    public function render(): View
    {
        return view('components.input.text.long-text');
    }
}
