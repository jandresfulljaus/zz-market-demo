<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fielddate extends Component
{
    public $label;
    public $name;
    public $data;
    public $value;
    public $classlabel;
    public $classinput;
    public $placeholder;
    public $default_empty;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$placeholder=null,$classinput=null,$classlabel=null,$empty=null)
    {
        $this->label = $label;
        $this->name = $name;
        if (isset($data, $data[$name]) && !empty($data)) {
            $datetime = new \DateTime($data[$name]);
            $this->value = $datetime->format('Y-m-d');
        } else {
            if ($empty == 'true') {
                $this->value = '';
            }else{
                $this->value = date('Y-m-d');
            }
        }

        $this->placeholder = $placeholder ?? '';
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
        return view('Components.Views.fielddate');
    }
}
