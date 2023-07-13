<?php

namespace App\Http\Livewire;

use App\Models\Servico;
use Livewire\Component;

class ProcessoNovo extends Component
{
    public $processo;
    public $nome;
    public $servicoId;
    public $servicos = [];

    protected $listeners = ['storeProcesso' => 'store'];

    public function addServico()
    {
        if ($this->servicoId == null || $this->servicoId == -1)
            return;
        $servico = Servico::find($this->servicoId)->toArray();
        if (!in_array($servico, $this->servicos))
            $this->servicos[] = $servico;
        $this->dispatchBrowserEvent('servico-added');
    }

    public function removeServico($id)
    {
        $this->servicos = array_filter($this->servicos, function ($servico) use ($id) {
            return $servico['id'] != $id;
        });
    }
    public function store()
    {
        debug($this->nome);
    }

    public function render()
    {
        return view('livewire.processo-novo');
            //->layout('layouts.despachante');
    }
}
