<?php

namespace App\Http\Livewire\despachante;

use App\Models\Atpv;
use Livewire\Component;

class Atpvs extends Component
{
    public $atpvs;
    public $clienteId;
    public $teste = 'teste';
    public $queryString;

    protected $listeners = ['onChange'];

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
        return redirect()->route('despachante.atpvs.show', $id);
    }

    public function render()
    {
        $this->queryString = ['teste'];
        $this->atpvs = Atpv::all();
        return view('livewire.despachante.atpvs')
            ->layout('layouts.despachante');
    }
}
