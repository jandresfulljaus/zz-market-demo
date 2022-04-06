<?php

namespace App\View\Components\Sidebar;

use Illuminate\View\Component;

class Card extends Component
{
    /**
     * The card title
     */
    public $title;

    /**
     * Whether the card is active or not
     */
    public $isActive;

    /**
     * Badge to show on the card header
     */
    public $badge;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $isActive, $badge = null)
    {
        $this->title = $title;
        $this->isActive = $isActive;
        $this->badge = $badge;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar.card');
    }
}
