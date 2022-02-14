<?php

namespace App\View\Components\Input\Text;

use App\View\Components\Input\InputTextComponent;
use Illuminate\Contracts\View\View;

class Basics extends InputTextComponent
{
    public function render(): View
    {
        return view('components.input.text.basics');
    }
}
