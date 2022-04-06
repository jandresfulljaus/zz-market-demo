<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Tkt extends Component
{
    public $datos;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data = null)
    {
        $this->datos = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.tkt');
    }
}
