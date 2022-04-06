<?php

namespace App\View\Components\Sidebar;

use Illuminate\View\Component;

class Item extends Component
{
    /**
     * The item state
     */
    public $isActive;

    /**
     * The item URL
     */
    public $url;

    /**
     * The item icon
     */
    public $icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isActive, $url, $icon)
    {
        $this->isActive = ($isActive) ? 'active' : '';
        $this->url = $url;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar.item');
    }
}
