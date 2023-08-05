<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SidebarBase extends Component
{
  public $showSideBar = false;
  public $params = [];

  public $listeners = [
    'showSideBar' => 'showSideBar',
  ];

  /*
   Toggles any child SideBar it's emmited to
   i.e window.livewire.emitTo('cart.SideBar', 'showSideBar')
   variable parameters are passed to the child component
   */
  public function showSideBar(...$params)
  {
    $this->params = $params;
    $this->showSideBar = !$this->showSideBar;
  }
}
