<?php

namespace App\View\Components\Forms\Selects;

use Illuminate\View\Component;

class Multiple extends Component
{
    /**
     * The select name
     */
    public $name;

    /**
     * The select values
     */
    public $values;

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
        $values,
        $items,
        $itemValueField,
        $itemTextField,
        $placeholder,
        $template = null,
        $dataTags = null
    )
    {
        $this->name = $name;
        $this->values = $values ?? [];
        $this->items = $items;
        $this->itemValueField = $itemValueField;
        $this->itemTextField = $itemTextField;
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
        return view('components.forms.selects.multiple');
    }

        /**
     * Determine if the given option is currently selected.
     *
     * @param  string  $option
     * @return bool
     */
    public function isSelected($option)
    {
        return in_array($option, $this->values);
    }
}
