<?php

namespace App\View\Components\Lists\Buttons;

use Illuminate\View\Component;

class Edit extends Component
{
    /**
     * The button URL
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.lists.buttons.edit');
    }
}
