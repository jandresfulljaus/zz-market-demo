<?php

namespace App\View\Components\Sidebar;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * The button URL
     */
    public $url;

    /**
     * The button color
     */
    public $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url, $color)
    {
        $this->url = $url;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar.button');
    }
}
