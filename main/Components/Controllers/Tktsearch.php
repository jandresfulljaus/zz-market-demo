<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Tktsearch extends Component
{
    public $containerid;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($containerid)
    {
        $this->containerid = $containerid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.tkt_search');
    }
}
