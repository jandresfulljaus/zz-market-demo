<?php

namespace Main\Components\Controllers;

use Illuminate\View\Component;

class Fieldswitch extends Component
{
    public $label;
    public $name;
    public $data;
    public $checked;
    public $classformgroup;
    public $classlabel;
    public $classinput;
    public $textoff;
    public $texton;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label,$name,$data,$classinput=null,$classlabel=null,$texton=null,$textoff=null,$default=null,$classformgroup=null)
    {
        $this->label = $label;
        $this->name = $name;
        if(isset($data, $data[$name])) {
            $this->checked = ($data[$name] === 1 || $data[$name] === 'on') ? 'checked' : '';
        } else {
            if (!empty($default)) {
                $this->checked = ($default === 'off') ? '' : $default;
            }else{
                $this->checked = 'checked';
            }
        }
        $this->classlabel = $classlabel ?? '';
        $this->classinput = $classinput ?? '';
        $this->texton = $texton ?? __('messages.statusActive');
        $this->textoff = $textoff ?? __('messages.statusInactive');
        $this->classformgroup = $classformgroup ?? '';

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Components.Views.fieldswitch');
    }
}
