<?php

namespace App\Http\Livewire;

use App\Models\Pedido;
use App\Models\Processo;
use App\Models\Servico;
use Livewire\Component;

class ProcessoShow extends Component
{
    public $processo;
    public $isEditing = false;
    public $qtdPlaca;
    public $compradorTipo;
    public $processoTipo;
    public $servicoId;
    public $servicos = [];
    public $status = 'ab';

    public function mount($id)
    {
        $processo = Processo::find($id);
        $this->processo = $processo;
        $this->nome = 'Kevin';
        $this->observacao = Pedido::find($processo->pedido_id)->observacoes;
        $this->servicos = Servico::all()->toArray();
    }

    public function addServico()
    {
        if ($this->servicoId == null || $this->servicoId == -1)
            return;
        $servico = Servico::find($this->servicoId)->toArray();
        if (!in_array($servico, $this->servicos))
            $this->servicos[] = $servico;
    }

    public function removeServico($id)
    {
        $this->servicos = array_filter($this->servicos, function ($servico) use ($id) {
            return $servico['id'] != $id;
        });
    }

    public function render()
    {
        debug($this->isEditing);

        if (auth()->user()->isDespachante())
            return view('livewire.processo-show')->layout('layouts.despachante');
        elseif (auth()->user()->isCliente())
            return view('livewire.processo-show')->layout('layouts.cliente');
        else
            abort(500);
    }
}
