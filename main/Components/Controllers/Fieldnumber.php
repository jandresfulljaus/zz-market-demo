<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldnumber extends Component
{
    public $label;
    public $name;
    public $data;
    public $placeholder;
    public $value;
    public $classlabel;
    public $classinput;
    public $min;
    public $max;
    public $step;
    public $readonly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$placeholder=null,$min=null,$max=null,$step=null,$classinput=null,$classlabel=null,$readonly=null)
    {
        $this->label = $label;
        $this->name = $name;
        if(isset($data, $data[$name])) {
            $this->value = $data[$name];
        } else {
            $this->value = null;
        }
        $this->classlabel = $classlabel ?? '';
        $this->classinput = $classinput ?? '';
        $this->placeholder = $placeholder ?? '';
        $this->min = $min ?? '';
        $this->max = $max ?? '';
        $this->step = $step ?? '';
        $this->readonly = $readonly ? 'readonly' : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldnumber');
    }
}
