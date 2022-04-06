<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldduallist extends Component
{
    public $label;
    public $name;
    public $data;
    public $datapivot;
    public $items;
    public $itemindex;
    public $itemtext;
    public $value = null;
    public $selected;
    public $classlabel;
    public $classinput;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$items,$itemindex,$itemtext,$classinput=null,$classlabel=null,$datapivot)
    {
        $this->label = $label;
        $this->name = $name;
        $this->data = $data;
        $this->datapivot = $datapivot;

        $this->classlabel = $classlabel ?? '';
        $this->classinput = $classinput ?? '';
        $this->items = $items;
        $this->itemindex = $itemindex;
        $this->itemtext = $itemtext;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldduallist');
    }
}
