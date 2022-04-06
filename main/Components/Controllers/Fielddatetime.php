<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fielddatetime extends Component
{
    public $label;
    public $name;
    public $data;
    public $date;
    public $time;
    public $classlabel;
    public $classinput;
    public $placeholder;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$placeholder=null,$classinput=null,$classlabel=null)
    {
        $this->label = $label;
        $this->name = $name;
        if (isset($data, $data[$name]) && !empty($data)) {
            $datetime = new \DateTime($data[$name]);
            $this->date = $datetime->format('Y-m-d');
            $this->time = $datetime->format('H:i');
        } else {
            $datetime = new \DateTime();
            $this->date = $datetime->format('Y-m-d');
            $this->time = $datetime->format('H:i');
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
        return view('Components.Views.fielddatetime');
    }
}
