<?php

namespace App\View\Components\Input\Select;

use App\View\Components\Input\InputSelectComponent;
use Illuminate\Contracts\View\View;

class Basics extends InputSelectComponent
{
    public function render(): View
    {
        return view('components.input.select.basics');
    }
}
