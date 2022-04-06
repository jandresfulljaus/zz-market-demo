<?php

namespace App\View\Components\Forms\Selects;

use Illuminate\View\Component;

class Grouped extends Component
{
    /**
     * The select name
     */
    public $name;

    /**
     * The select value
     */
    public $value;

    /**
     * The select items
     */
    public $items;

    /**
     * The item field to use as the option value
     */
    public $itemValueField;

    /**
     * The item field to use as the option text
     */
    public $itemTextField;

    /**
     * The select placeholder option
     */
    public $placeholder;

    /**
     * The select template
     */
    public $template;

    /**
     * The data tags to add to each option element
     */
    public $dataTags;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $value,
        $items,
        $itemValueField,
        $itemTextField,
        $placeholder,
        $template = null,
        $dataTags = null
    )
    {
        $this->name = $name;
        $this->items = $items;
        $this->itemValueField = $itemValueField;
        $this->itemTextField = $itemTextField;
        $this->value = (int) $value;
        $this->placeholder = $placeholder;
        $this->template = $template;
        $this->dataTags = $dataTags;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.selects.grouped');
    }

    /**
     * Determine if the given option is the currently selected option.
     *
     * @param  string  $option
     * @return bool
     */
    public function isSelected($option)
    {
        return $option === $this->value;
    }
}
