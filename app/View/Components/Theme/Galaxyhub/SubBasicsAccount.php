<?php

namespace App\View\Components\Theme\Galaxyhub;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubBasicsAccount extends Component
{
    public string $title;
    public string $description;
    public string $class;
    public User $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title = '', string $description = '', string $class = '', User $user = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->class = $class;
        $this->user = $user;
    }

    public function render(): View
    {
        return view('components.theme.galaxyhub.sub-basics-account');
    }
}
