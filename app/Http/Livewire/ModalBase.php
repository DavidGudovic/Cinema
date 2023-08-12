<?php

namespace App\Http\Livewire;

use Livewire\Component;

/*
Base Modal class
*/
class ModalBase extends Component
{
    public $showModal = false;
    public $showModalSecond = false;
    public $params = [];

    public $listeners = [
        'showModal' => 'showModal',
        'showModalSecond' => 'showModalSecond',
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
    /* Needed if there are 2 models on the page, didnt think it through no time to fix now */
    public function showModalSecond(...$params)
    {
        $this->params = $params;
        $this->showModalSecond = !$this->showModalSecond;
    }
}
