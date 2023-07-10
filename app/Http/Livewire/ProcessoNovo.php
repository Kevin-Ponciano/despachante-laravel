<?php

namespace App\Http\Livewire;

use App\Models\Servico;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProcessoNovo extends Component
{
    public $processo;
    public $nome;
    public $servicos_id;
    public $servicos = [];

    protected $listeners = ['storeProcesso' => 'store'];

    public function addServico()
    {
        if ($this->servicos_id == null || $this->servicos_id == -1)
            return;
        $servico = Servico::find($this->servicos_id)->toArray();
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
        return view('livewire.despachante.processo-novo')
            ->layout('layouts.despachante');
    }
}
