<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldtextgroup extends Component
{
    public $label;
    public $data;
    public $name1;
    public $placeholder1;
    public $width1;
    public $value1;
    public $name2;
    public $placeholder2;
    public $width2;
    public $value2;
    public $classlabel;
    public $classinput;
    public $maxlength1;
    public $maxlength2;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$data,$name1,$placeholder1,$width1,$name2,$placeholder2,$width2,$classinput=null,$classlabel=null, $maxlength1=null, $maxlength2=null)
    {
        $this->label = $label;
        if(isset($data) && !empty($data))
        {
            $this->value1 = $data[$name1];
            $this->value2 = $data[$name2];
        }
        $this->name1 = $name1;
        $this->width1 = $width1 ?? '6';
        $this->placeholder1 = $placeholder1 ?? '';

        $this->name2 = $name2;
        $this->width2 = $width2 ?? '6';
        $this->classlabel = $classlabel ?? '';
        $this->classinput = $classinput ?? '';        
        $this->placeholder2 = $placeholder2 ?? '';
        $this->maxlength1 = $maxlength1 ?? 255;
        $this->maxlength2 = $maxlength2 ?? 255;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldtextgroup');
    }
}
