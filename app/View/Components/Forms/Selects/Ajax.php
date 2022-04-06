<?php

namespace App\View\Components\Forms\Selects;

use Illuminate\View\Component;

class Ajax extends Component
{
    /**
     * The select name
     */
    public $name;

    /**
     * The select url for AJAX requests
     */
    public $url;

    /**
     * The select placeholder option
     */
    public $placeholder;

    /**
     * The select items
     */
    public $item;

    /**
     * The item field to use as the option value
     */
    public $itemValueField;

    /**
     * The item field to use as the option text
     */
    public $itemTextField;

    /**
     * The select template
     */
    public $template;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $url,
        $placeholder,
        $item = null,
        $itemValueField = null,
        $itemTextField = null,
        $template = null
    )
    {
        $this->name = $name;
        $this->url = $url;
        $this->placeholder = $placeholder;
        $this->item = $item;
        $this->itemValueField = $itemValueField;
        $this->itemTextField = $itemTextField;
        $this->template = $template;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.selects.ajax');
    }
}
