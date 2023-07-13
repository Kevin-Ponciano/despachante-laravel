<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AtpvNovo extends Component
{
    public $isRenave = false;
    public $col_length = 4;
    public $cep;
    public $uf = 'SP';

    protected $listeners = [
        'storeAtpv' => 'store',
        'cep-found' => 'cepAtributesChange'
    ];

    public function renaveSwitch()
    {
        $this->isRenave = !$this->isRenave;
        $this->col_length = $this->isRenave ? 3 : 4;
    }
    public function cepAtributesChange($dados)
    {
        $this->uf = $dados['uf'];
    }

    public function store()
    {
        debug($this->uf);
    }

    public function render()
    {
        return view('livewire.atpv-novo');
    }
}
