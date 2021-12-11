<?php

namespace App\View\Components\Input\Text;

use Illuminate\View\Component;

class Primary extends Component
{
    public string $type;
    public string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'text', $class = '')
    {
        $this->type = $type;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.text.primary');
    }
}
