<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldhidden extends Component
{
    public $name;
    public $data;
    public $value;
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$data=null,$value=null,$id=null)
    {
        $this->name = $name;
        if(!empty($data))
        {
            if(isset($data[$name]))
            {
                $this->value = $data[$name];
            }
        }
        if(!empty($value))
        {
            $this->value = $value;
        }
        if(!empty($id))
        {
            $this->id = $id;    
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldhidden');
    }
}
