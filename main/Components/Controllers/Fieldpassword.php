<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldpassword extends Component
{
    public $label;
    public $name;
    public $data;
    public $placeholder;
    public $value;
    public $classlabel;
    public $classinput;
    public $autocomplete;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data = null,$placeholder=null,$classinput=null,$classlabel=null, $autocomplete=null)
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
        $this->autocomplete = $autocomplete ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldpassword');
    }
}
