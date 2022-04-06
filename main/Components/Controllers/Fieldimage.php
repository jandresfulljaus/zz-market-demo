<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldimage extends Component
{
    public $label;
    public $name;
    public $data;
    public $value;
    public $uniqid;
    public $index;
    /*
    Listado de opciones de cropperjs:
        https://github.com/fengyuanchen/cropperjs/blob/master/README.md#options
    */
    public $cropOptions;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$index='0',$files=null,$filetext='',$fileindex='',$cropOptions=null)
    {
        $this->label = $label;
        $this->name = $name;
        if(isset($files) && !empty($files) && isset($index) && isset($files[$index]))
        {
            $this->value=$files[$index][$filetext];
            //$this->value = '';
        } else {
            if(isset($data[$name]) && !empty($data[$name]))
            {
                $this->value = $data[$name];
            } else {
                $this->value = '';
            }            
        }
        $this->uniqid = uniqid();
        $this->cropOptions = $cropOptions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldimage');
    }
}
