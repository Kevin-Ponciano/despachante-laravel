<?php

namespace App\Http\Livewire;

use App\Models\PedidoServico;
use App\Traits\FunctionsTrait;
use Auth;
use Livewire\Component;

class ProcessoShow extends Component
{
    use FunctionsTrait;

    public $pedido;
    public $cliente;
    public $compradorNome;
    public $telefone;
    public $placa;
    public $veiculo;
    public $qtdPlaca;
    public $compradorTipo;
    public $processoTipo;
    public $observacoes;
    public $arquivos = [];
    public $precoPlaca;
    public $precoHonorario;
    public $servicosDespachante = [];

    public $servicos = [];
    public $servicoId;
    public $isEditing = false;

    protected $rules = [
        'compradorNome' => 'required',
        'telefone' => 'required|between:14,15',
        'placa' => 'required|between:7,7',
        'veiculo' => 'required',
    ];

    protected $messages = [
        'compradorNome.required' => 'Obrigatório.',
        'telefone.required' => 'Obrigatório.',
        'telefone.between' => 'Telefone inválido.',
        'placa.required' => 'Obrigatório.',
        'placa.between' => 'Placa inválida.',
        'veiculo.required' => 'Obrigatório.',
    ];

    public function mount($id)
    {
        $this->pedido = Auth::user()->despachante->pedidos()->where('numero_pedido', $id)->firstOrFail();
        $this->cliente = $this->pedido->cliente->nome;
        $this->compradorNome = $this->pedido->comprador_nome;
        $this->telefone = $this->pedido->comprador_telefone;
        $this->placa = $this->pedido->placa;
        $this->veiculo = $this->pedido->veiculo;
        $this->qtdPlaca = $this->pedido->processo->qtd_placas;
        $this->compradorTipo = $this->pedido->processo->comprador_tipo;
        $this->processoTipo = $this->pedido->processo->tipo;
        $this->observacoes = $this->pedido->observacoes;
        $this->precoPlaca = $this->regexMoneyToView($this->pedido->processo->preco_placa);
        $this->precoHonorario = $this->regexMoneyToView($this->pedido->preco_honorario);
        foreach ($this->pedido->servicos as $servico) {
            $servico->preco = $this->regexMoneyToView($servico->pivot->preco);
            $this->servicos[] = $servico->toArray();
        }
        $this->servicosDespachante = Auth::user()->despachante->servicos;
    }

    public function addServico()
    {
        if ($this->servicoId == null || $this->servicoId == -1)
            return;
        $servico = Auth::user()->despachante->servicos()->find($this->servicoId)->toArray();
        $serviceIds = array_map(function ($service) {
            return $service['id'];
        }, $this->servicos);
        if (!in_array($servico['id'], $serviceIds)) {
            $servico['preco'] = $this->regexMoneyToView($servico['preco']);
            $this->servicos[] = $servico;
            PedidoServico::create([
                'pedido_id' => $this->pedido->id,
                'servico_id' => $servico['id'],
                'preco' => $this->regexMoney($servico['preco']),
            ]);
            $this->emit('savedPriceServico');
        }
    }

    public function removeServico($id)
    {
        $this->servicos = array_filter($this->servicos, function ($servico) use ($id) {
            return $servico['id'] != $id;
        });
        PedidoServico::where('pedido_id', $this->pedido->id)->where('servico_id', $id)->delete();
        $this->emit('savedPriceServico');
    }

    public function savePriceServico($index)
    {
        $servico = $this->servicos[$index];
        if ($servico['preco'] == null)
            return;
        $servico['preco'] = $this->regexMoney($servico['preco']);
        PedidoServico::where('pedido_id', $this->pedido->id)->where('servico_id', $servico['id'])->update([
            'preco' => $servico['preco'],
        ]);
        $this->emit('savedPriceServico');
    }

    public function savePrecoPlaca()
    {
        if ($this->precoPlaca == null)
            return;
        $this->pedido->processo->update([
            'preco_placa' => $this->regexMoney($this->precoPlaca),
        ]);
        $this->emit('savedPrecoPlaca');
    }

    public function savePrecoHonorario()
    {
        if ($this->precoHonorario == null)
            return;
        $this->pedido->update([
            'preco_honorario' => $this->regexMoney($this->precoHonorario),
        ]);
        $this->emit('savedPrecoHonorario');
    }

    public function update()
    {
        if (!$this->isEditing)
            return;
        $this->validate();
        $this->pedido->update([
            'comprador_nome' => $this->compradorNome,
            'comprador_telefone' => $this->telefone,
            'placa' => $this->placa,
            'veiculo' => $this->veiculo,
            'observacoes' => $this->observacoes,
        ]);
        $this->pedido->processo->update([
            'tipo' => $this->processoTipo,
            'comprador_tipo' => $this->compradorTipo,
            'qtd_placas' => $this->qtdPlaca,
        ]);
        $this->isEditing = false;
        $this->emit('success', [
            'message' => 'Processo Salvo com sucesso',
        ]);
    }

    public function render()
    {
        if (auth()->user()->isDespachante())
            return view('livewire.processo-show')->layout('layouts.despachante');
        elseif (auth()->user()->isCliente())
            return view('livewire.processo-show')->layout('layouts.cliente');
        else
            abort(500);
    }
}
