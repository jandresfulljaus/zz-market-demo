<?php

namespace App\View\Components\Forms\Custom;

use Illuminate\View\Component;

class Switchery extends Component
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
     * The on state label
     */
    public $onLabel;

    /**
     * The off state label
     */
    public $offLabel;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $value, $onLabel = null, $offLabel = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->onLabel = $onLabel;
        $this->offLabel = $offLabel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.custom.switchery');
    }

    /**
     * Determine if the input is checked.
     *
     * @param  string  $value
     * @return bool
     */
    public function isChecked($value)
    {
        return ($value === 1 || $value === 'on');
    }
}
