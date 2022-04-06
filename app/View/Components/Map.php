<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Map extends Component
{
    /**
     * The map latitude coordinates
     */
    public $latitude;

    /**
     * The map longitude coordinates
     */
    public $longitude;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.map');
    }
}
