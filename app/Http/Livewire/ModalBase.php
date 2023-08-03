<?php

namespace App\Http\Livewire;

use Livewire\Component;

/*
  Base Modal class
*/
class ModalBase extends Component
{
  public $showModal = false;
  public $params = [];

  public $listeners = [
    'showModal' => 'showModal',
  ];

  /*
   Toggles any child modal it's emmited to
   i.e window.livewire.emitTo('cart.modal', 'showModal')
   variable parameters are passed to the child component
   */
  public function showModal(...$params)
  {
    $this->params = $params;
    $this->showModal = !$this->showModal;
  }
}
