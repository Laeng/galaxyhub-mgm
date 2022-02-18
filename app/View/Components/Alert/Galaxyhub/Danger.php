<?php

namespace App\View\Components\Alert\Galaxyhub;

use App\View\Components\Alert\Skeleton;
use Illuminate\Contracts\View\View;

class Danger extends Skeleton
{
    public function render(): View
    {
        return view('components.alert.galaxyhub.danger');
    }
}
