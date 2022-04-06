<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldtextarea extends Component
{
    public $label;
    public $name;
    public $data;
    public $value;
    public $editor;
    public $rows;
    public $classlabel;
    public $classinput;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$rows=null,$classinput=null,$classlabel=null)
    {
        $this->label = $label;
        $this->name = $name;
        if(isset($data) && isset($data[$name]))
        {
            $this->value = $data[$name];
        } else {
            $this->value = '';
        }
        $this->rows = $rows;
        $this->classlabel = $classlabel ?? '';
        $this->classinput = $classinput ?? '';

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldtextarea');
    }
}
