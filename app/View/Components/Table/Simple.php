<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Simple extends Component
{
    private string $componentId;
    private string $apiUrl;
    private bool $useCheckBox;
    private string $checkBoxName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $apiUrl, bool $useCheckBox = false, string $checkBoxName = '')
    {
        $this->componentId = \Str::random(8);
        $this->apiUrl = $apiUrl;
        $this->useCheckBox = $useCheckBox;
        $this->checkBoxName = $checkBoxName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.table.simple', [
            'componentId' => $this->componentId,
            'apiUrl' => $this->apiUrl,
            'useCheckBox' => $this->useCheckBox,
            'checkBoxName' => $this->checkBoxName
        ]);
    }
}
