<?php

namespace App\View\Components\PageHeader;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * The button URL
     */
    public $url;

    /**
     * The button icon
     */
    public $icon;

    /**
     * The button color
     */
    public $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url, $icon, $color = "text-primary")
    {
        $this->url = $url;
        $this->icon = $icon;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.page-header.button');
    }
}
