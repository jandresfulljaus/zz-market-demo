<?php

namespace App\View\Components\Forms\Custom\Ckeditor;

use Illuminate\View\Component;

class Basic extends Component
{
    /**
     * The input name
     */
    public $name;

    /**
     * The input value
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.custom.ckeditor.basic');
    }
}
