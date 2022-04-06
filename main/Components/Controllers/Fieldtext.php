<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldtext extends Component
{
    public $label;
    public $name;
    public $data;
    public $maxlength;
    public $placeholder;
    public $value;
    public $classlabel;
    public $classinput;
    public $readonly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$placeholder,$classinput=null,$classlabel=null, $maxlength=null, $readonly=null)
    {
        $this->label = $label;
        $this->name = $name;
        if(isset($data) && isset($data[$name]))
        {
            $this->value = $data[$name];
        } else {
            $this->value = '';
        }
        $this->maxlength = $maxlength ?? '255';
        $this->classlabel = $classlabel ?? '';
        $this->classinput = $classinput ?? '';       
        $this->placeholder = $placeholder ?? '';
        $this->readonly = $readonly ? 'readonly' : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldtext');
    }
}
