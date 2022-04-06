<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldselectajax extends Component
{
    public $label;
    public $name;
    public $data;
    public $itemsurl;
    public $itemindex;
    public $itemtext;
    public $value;
    public $selected;
    public $classlabel;
    public $classinput;
    public $template;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$items,$itemsurl,$itemindex,$itemtext,$classinput=null,$classlabel=null,$template=null, $parametro=array())
    {
        $this->label = $label;
        $this->name = $name;
        if(isset($data) && !empty($data))
        {
            $this->value = $data[$name];
            foreach($items as $i => $item)
            {
                if($item[$itemindex]==$this->value)
                {
                    $this->selected=$item[$itemtext];
                }
            }
        } else {
            // Si viene el person_id por GET lo precargo
            if(isset($parametro[0]->name)){
                $this->value = $parametro[0]->id;
                $this->selected= $parametro[0]->name;
            }
            else{
                $this->value = '';
                $this->selected=__('messages.selectAnOption');
            }
        }

        $this->classlabel = $classlabel ?? '';
        $this->classinput = $classinput ?? '';
        $this->itemsurl = $itemsurl;
        $this->itemindex = $itemindex;
        $this->itemtext = $itemtext;
        $this->template = $template;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldselectajax');
    }
}
