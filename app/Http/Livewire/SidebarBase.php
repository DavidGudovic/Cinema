<?php

namespace App\Http\Livewire;

use Livewire\Component;

/**
* Base Sidebar class
*/
class SidebarBase extends Component
{
    public $showSideBar = false;
    public $params = [];

    public $listeners = [
        'showSideBar' => 'showSideBar',
    ];

    /**
     * Toggles any child SideBar it's emitted to
     * i.e. window.livewire.emitTo('cart.SideBar', 'showSideBar')
     * variable parameters are passed to the child component
     */
    public function showSideBar(...$params): void
    {
        $this->params = $params;
        $this->showSideBar = !$this->showSideBar;
    }
}
