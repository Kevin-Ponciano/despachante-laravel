<?php

namespace App\Http\Livewire\despachante;

use App\Models\Cliente;
use Livewire\Component;

class ClienteEditar extends Component
{
    public $cliente;
    public $nomeCliente;
    public $nomeUsuario;
    public $preco1Placa;
    public $preco2Placa;
    public $precoAtpv;
    public $precoLoja;
    public $precoTerceiro;

    public function mount($id)
    {
        $this->cliente = Cliente::findOrFail($id);
        $this->nomeCliente = $this->cliente->nome;
        //$this->nomeUsuario = $this->cliente->user->name;
        $this->preco1Placa = $this->cliente->preco_1_placa;
        $this->preco2Placa = $this->cliente->preco_2_placa;
        $this->precoAtpv = $this->cliente->preco_atpv;
        $this->precoLoja = $this->cliente->preco_loja;
        $this->precoTerceiro = $this->cliente->preco_terceiro;
    }

    public function changeName()
    {
        $this->cliente->update([
           'nome' => $this->nomeCliente,
        ]);
        $this->emit('savedName');
    }

    public function render()
    {
        return view('livewire.despachante.cliente-editar')
            ->layout('layouts.despachante');
    }
}
