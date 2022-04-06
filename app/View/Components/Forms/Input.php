<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * The input type
     */
    public $type;

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
    public function __construct($type, $name, $value)
    {
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
