<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldemail extends Component
{
    public $label;
    public $name;
    public $data;
    public $placeholder;
    public $value;
    public $classlabel;
    public $classinput;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$placeholder,$classinput=null,$classlabel=null)
    {
        $this->label = $label;
        $this->name = $name;
        if(isset($data) && isset($data[$name]))
        {
            $this->value = $data[$name];
        } else {
            $this->value = '';
        }
        $this->classlabel = $classlabel ?? '';
        $this->classinput = $classinput ?? '';
        $this->placeholder = $placeholder ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldemail');
    }
}
