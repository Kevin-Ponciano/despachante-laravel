<?php

namespace App\Http\Livewire;

use App\Models\Pedido;
use App\Models\PedidoServico;
use App\Models\Processo;
use App\Traits\FunctionsTrait;
use App\Traits\HandinFilesTrait;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProcessoNovo extends Component
{
    use WithFileUploads;
    use HandinFilesTrait;
    use FunctionsTrait;

    public $clientes;
    public $clienteId;
    public $cliente;
    public $compradorNome;
    public $telefone;
    public $placa;
    public $veiculo;
    public $qtdPlacas = 0;
    public $compradorTipo = 'tc';
    public $processoTipo = 'ss';
    public $observacoes;
    public $arquivos = [];
    public $precoPlaca;
    public $precoHonorario;
    public $servicosDespachante = [];

    public $servicos = [];
    public $servicoId;
    public $precoSettado = false;

    protected $rules = [
        'clienteId' => 'required|exists:clientes,id',
        'compradorNome' => 'required',
        'telefone' => 'required|min:14|max:15',
        'placa' => 'required|between:7,7',
        'veiculo' => 'required',
        'arquivos.*' => 'mimes:pdf|max:10240', // 10MB Max
    ];

    protected $messages = [
        'clienteId.required' => 'Selecione um Cliente.',
        'clienteId.exists' => 'Selecione um Cliente.',
        'compradorNome.required' => 'Obrigatório.',
        'telefone.required' => 'Obrigatório.',
        'telefone.between' => 'Telefone inválido.',
        'placa.required' => 'Obrigatório.',
        'placa.min' => 'Placa inválida.',
        'placa.max' => 'Placa inválida.',
        'veiculo.required' => 'Obrigatório.',
        'arquivos.*.mimes' => 'Formato inválido (Somente PDF).',
        'arquivos.*.max' => 'Tamanho máximo de 10MB.',
    ];

    public function mount()
    {
        $this->clientes = \Auth::user()->despachante->clientes;
        $this->servicosDespachante = \Auth::user()->despachante->servicos;
    }

    public function updatedArquivos()
    {
        $this->validate([
            'arquivos.*' => 'mimes:pdf|max:10240', // 10MB Max
        ]);
    }

    public function setPrecoPlaca()
    {
        if ($this->clienteId == null || $this->clienteId == -1)
            return;
        if ($this->qtdPlacas == 1)
            $this->precoPlaca = $this->cliente->preco_1_placa;
        elseif ($this->qtdPlacas == 2)
            $this->precoPlaca = $this->cliente->preco_2_placa;
        else
            $this->precoPlaca = 0;
    }

    public function setPrecoHonorario()
    {
        if ($this->clienteId == null || $this->clienteId == -1)
            return;
        if ($this->compradorTipo == 'tc')
            $this->precoHonorario = $this->cliente->preco_terceiro;
        elseif ($this->compradorTipo == 'lj')
            $this->precoHonorario = $this->cliente->preco_loja;
    }

    public function setPrecos()
    {
        if ($this->clienteId == null || $this->clienteId == -1)
            return;
        $this->cliente = \Auth::user()->despachante->clientes()->find($this->clienteId);
        $this->setPrecoPlaca();
        $this->setPrecoHonorario();
        $this->precoSettado = true;
    }

    public function addServico()
    {
        if ($this->servicoId == null || $this->servicoId == -1)
            return;
        $servico = \Auth::user()->despachante->servicos()->find($this->servicoId)->toArray();
        $serviceIds = array_map(function ($service) {
            return $service['id'];
        }, $this->servicos);
        if (!in_array($servico['id'], $serviceIds)) {
            $this->servicos[] = $servico;
        }
    }

    public function removeServico($id)
    {
        $this->servicos = array_filter($this->servicos, function ($servico) use ($id) {
            return $servico['id'] != $id;
        });
    }

    public function store()
    {
        $this->validate();
        if (!$this->precoSettado) {
            $this->setPrecos();
        }
        $pedido = Pedido::create([
            'comprador_nome' => $this->compradorNome,
            'comprador_telefone' => $this->telefone,
            'placa' => $this->placa,
            'veiculo' => $this->veiculo,
            'preco_honorario' => $this->regexMoney($this->precoHonorario),
            'status' => 'ab',
            'observacoes' => $this->observacoes,
            'criado_por' => \Auth::user()->id,
            'cliente_id' => $this->clienteId,
        ]);
        $processo = Processo::create([
            'tipo' => $this->processoTipo,
            'comprador_tipo' => $this->compradorTipo,
            'qtd_placas' => $this->qtdPlacas,
            'preco_placa' => $this->regexMoney($this->precoPlaca),
            'pedido_id' => $pedido->id,
        ]);
        if (!empty($this->servicos)) {
            foreach ($this->servicos as $servico) {
                PedidoServico::create([
                    'pedido_id' => $pedido->id,
                    'servico_id' => $servico['id'],
                    'preco' => $this->regexMoney($servico['preco']),
                ]);
            }
        }
        // todo verificar uma forma caso de erro ao salvar os arquivos reverter os dados salvos no banco
        $this->saveFiles($this->arquivos, $this->cliente, $pedido);

        $this->clearInputs();
        $this->emit('$refresh');
        $this->emit('success', [
            'message' => 'Processo criado com sucesso.',
            'url' => route('despachante.processos.show', $processo->id),
        ]);
    }

    public function clearInputs()
    {
        $this->resetValidation();
        $this->compradorNome = null;
        $this->telefone = null;
        $this->placa = null;
        $this->veiculo = null;
        $this->qtdPlacas = 0;
        $this->compradorTipo = 'tc';
        $this->processoTipo = 'ss';
        $this->observacoes = null;
        $this->precoPlaca = null;
        $this->precoHonorario = null;
        $this->servicos = [];
        $this->servicoId = null;
    }

    public function render()
    {
        return view('livewire.processo-novo');
    }
}
