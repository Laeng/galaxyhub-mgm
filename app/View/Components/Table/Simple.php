<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Simple extends Component
{
    public string $componentId;
    public string $apiUrl;
    public bool $useCheckBox;
    public string $checkBoxName;
    public bool $refresh;
    public int $limit;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $componentId, string $apiUrl, bool $useCheckBox = false, string $checkBoxName = '', bool $refresh = false, int $limit = 20)
    {
        $this->componentId = $componentId;
        $this->apiUrl = $apiUrl;
        $this->useCheckBox = $useCheckBox;
        $this->checkBoxName = $checkBoxName;
        $this->refresh = $refresh;
        $this->limit = $limit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.table.simple');
    }
}
