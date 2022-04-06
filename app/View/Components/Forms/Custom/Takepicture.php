<?php

namespace App\View\Components\Forms\Custom;

use Illuminate\View\Component;

class Takepicture extends Component
{
    public $id;
    public $name;
    public $button;
    public $fileInputId;
    public $title;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = null, $name = null, $button = null, $fileInputId = null, $title = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->button = $button;
        $this->fileInputId = $fileInputId ?? '';
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.custom.takepicture');
    }

}
