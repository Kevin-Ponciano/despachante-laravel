<?php

namespace App\Http\Livewire;

use App\Models\Pedido;
use App\Models\PedidoServico;
use App\Models\Processo;
use App\Traits\FunctionsHelpers;
use App\Traits\HandinFiles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Log;
use Throwable;

class ProcessoNovo extends Component
{
    use HandinFiles;
    use FunctionsHelpers;

    public $clientes;
    public $clienteId;
    public $cliente;
    public $compradorNome;
    public $telefone;
    public $responsavelNome;
    public $placa;
    public $veiculo;
    public $qtdPlacas = 0;
    public $compradorTipo = 'tc';
    public $processoTipo = 'ss';
    public $observacoes;
    public $precoPlaca;
    public $precoHonorario;
    public $servicosDespachante = [];

    public $servicos = [];
    public $servicoId;
    public $precoSettado = false;
    public $pedido;

    protected $rules = [
        'clienteId' => 'required|exists:clientes,id',
        'compradorNome' => 'required',
        'telefone' => 'required|min:14|max:15',
        'placa' => 'required|between:7,7',
        'veiculo' => 'required',
        'servicos' => 'required_if:processoTipo,ss',
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
        'servicos.required_if' => 'Obrigatório. Selecione ao menos um serviço.',
    ];

    public function mount()
    {
        if (\Auth::user()->isDespachante()) {
            $this->clientes = \Auth::user()->despachante->clientes->toArray();
            $this->servicosDespachante = \Auth::user()->despachante->servicos()->orderBy('nome')->get();
        } else {
            $this->clienteId = \Auth::user()->cliente->id;
            $this->servicosDespachante = \Auth::user()->cliente->despachante->servicos()->orderBy('nome')->get();
        }
    }

    public function addServico()
    {
        try {
            if ($this->servicoId == null || $this->servicoId == -1)
                return;
            if (\Auth::user()->isDespachante())
                $servico = \Auth::user()->despachante->servicos()->find($this->servicoId)->toArray();
            else
                $servico = \Auth::user()->cliente->despachante->servicos()->find($this->servicoId)->toArray();
            $serviceIds = array_map(function ($service) {
                return $service['id'];
            }, $this->servicos);
            if (!in_array($servico['id'], $serviceIds)) {
                $this->servicos[] = $servico;
            }
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao adicionar serviço.');
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

        if (\Auth::user()->isCliente() && empty($this->arquivos)) {
            return $this->addError('arquivos.*', 'Obrigatório.');
        }
        if (!$this->precoSettado) {
            $this->setPrecos();
        }
        $pedido = Pedido::create([
            'comprador_nome' => $this->compradorNome,
            'comprador_telefone' => $this->telefone,
            'responsavel_nome' => $this->responsavelNome,
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
        if ($this->processoTipo === 'ss' && !empty($this->servicos)) {
            foreach ($this->servicos as $servico) {
                PedidoServico::create([
                    'pedido_id' => $pedido->id,
                    'servico_id' => $servico['id'],
                    'preco' => $this->regexMoney($servico['preco']),
                ]);
            }
        }

        //TODO: verificar uma forma caso de erro ao salvar os arquivos reverter os dados salvos no banco
        $this->pedido = $pedido;
        if (!empty($this->arquivos))
            $this->uploadFiles('processos');

        $pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Processo criado',
            'descricao' => 'O Processo foi criado por <b>' . Auth::user()->name . '</b>.',
            'tipo' => 'np',
        ]);

        if (\Auth::user()->isDespachante()) {
            $url = route('despachante.processos.show', $pedido->numero_pedido);
        } else {
            $url = route('cliente.processos.show', $pedido->numero_pedido);
        }
        $this->clearInputs();
        $this->emit('$refresh');
        $this->emit('success', [
            'message' => 'Processo criado com sucesso.',
            'url' => $url,
        ]);
    }

    public function setPrecos()
    {
        if ($this->clienteId == null || $this->clienteId == -1)
            return;
        if (\Auth::user()->isDespachante())
            $this->cliente = \Auth::user()->despachante->clientes()->find($this->clienteId);
        else
            $this->cliente = \Auth::user()->cliente;
        $this->setPrecoPlaca();
        $this->setPrecoHonorario();
        $this->precoSettado = true;
    }

    public function setPrecoPlaca()
    {
        if ($this->clienteId == null || $this->clienteId == -1)
            return;
        if ($this->qtdPlacas == 1)
            $this->precoPlaca = $this->regexMoneyToView($this->cliente->preco_1_placa);
        elseif ($this->qtdPlacas == 2)
            $this->precoPlaca = $this->regexMoneyToView($this->cliente->preco_2_placa);
        else
            $this->precoPlaca = 0;
    }

    public function setPrecoHonorario()
    {
        if ($this->clienteId == null || $this->clienteId == -1)
            return;
        if ($this->compradorTipo == 'tc')
            $this->precoHonorario = $this->regexMoneyToView($this->cliente->preco_terceiro);
        elseif ($this->compradorTipo == 'lj')
            $this->precoHonorario = $this->regexMoneyToView($this->cliente->preco_loja);
    }

    public function clearInputs()
    {
        $this->resetValidation();
        $this->compradorNome = null;
        $this->telefone = null;
        $this->responsavelNome = null;
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
