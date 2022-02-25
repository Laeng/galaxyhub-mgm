<?php

namespace App\View\Components\List\Galaxyhub;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Basics extends Component
{
    public string $componentId;
    public string $action;
    public int $limit;
    public string $query;
    public bool $refresh;

    public function __construct(string $componentId = '', string $action = '', int $limit = 10, string $query = '{}', bool $refresh = false)
    {
        $this->componentId = $componentId;
        $this->action = $action;
        $this->limit = $limit;
        $this->query = $query;
        $this->refresh = $refresh;

    }

    public function render(): View
    {
        return view('components.list.galaxyhub.basics');
    }
}
