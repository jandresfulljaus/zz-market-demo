<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldselect extends Component
{
    public $id;
    public $label;
    public $name;
    public $data;
    public $items;
    public $itemindex;
    public $itemtext;
    public $optionalText;
    public $value = null;
    public $selected;
    public $classlabel;
    public $classinput;
    public $classselect = 'form-control-select2';
    public $template;
    public $datatags;
    public $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label,
        $name,
        $data,
        $items,
        $itemindex,
        $itemtext,
        $optionalText = null,
        $id = null,
        $classinput = null,
        $classlabel = null,
        $template = null,
        $datatags = null,
        $disabled = null
    )
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->data = $data;

        if(!empty($data) and isset($data[$name]))
        {
            $this->value = $data[$name];
        } else {
            $this->value = '';
        }

        $this->classlabel = $classlabel ?? '';
        $this->classinput = $classinput ?? '';
        $this->items = $items;
        $this->itemindex = $itemindex;
        $this->itemtext = $itemtext;
        $this->optionalText = $optionalText;
        $this->disabled = $disabled ? 'disabled' : '';

        if (!empty($datatags)) {
            // limpiar los espacios en blanco
            $datatags = str_replace(' ', '', $datatags);

            $this->datatags = explode(',', $datatags);
        }

        $this->template = $template ?? '';
        if (!empty($this->template)) {
            $this->classselect .= '-custom-template';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldselect');
    }
}
