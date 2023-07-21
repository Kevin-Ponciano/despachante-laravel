<?php

namespace App\Http\Livewire\cliente;

use App\Models\Atpv;
use Livewire\Component;

class Atpvs extends Component
{
    public $atpvs;
    public $clienteId;
    public $teste = 'teste';
    public $queryString;

    protected $listeners = ['onChange'];

    public function mount()
    {
        $this->queryString = ['clienteId'];
        $this->atpvs = Atpv::all();
    }

    public function onChange($clienteId)
    {
        $this->clienteId = $clienteId;
        debug($this->clienteId);
        $this->emit('selected');
    }
    public function selected()
    {
        debug($this->cliente);
        $this->emit('selected');
    }

    public function toRedirect($id)
    {
        return redirect()->route('cliente.atpvs.show', $id);
    }

    public function teste($id)
    {
        debug('ID: ' . $id);
    }

    public function render()
    {
        return view('livewire.cliente.atpvs')
            ->layout('layouts.cliente');
    }
}
