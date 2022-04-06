<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldmap extends Component
{
    public $data;
    public $addressname;
    public $latname;
    public $lngname;
    public $addressvalue;
    public $latvalue;
    public $lngvalue;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data, $addressname, $latname, $lngname)
    {
        $this->addressname = $addressname;
        $this->latname = $latname;
        $this->lngname = $lngname;
        $this->addressvalue = $data[$addressname] ?? null;
        $this->latvalue = $data[$latname] ?? null;
        $this->lngvalue = $data[$lngname] ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldmap');
    }
}
