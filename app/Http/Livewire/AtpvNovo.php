<?php

namespace App\Http\Livewire;

use App\Models\Atpv;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Traits\FunctionsTrait;
use Livewire\Component;

class AtpvNovo extends Component
{
    use FunctionsTrait;

    public $clientes;
    public $clienteId;
    public $veiculo;
    public $vendedor;
    public $comprador;

    public $endereco;
    public $observacoes;
    public $isRenave = false;

    protected $rules = [
        'clienteId' => 'required|exists:clientes,id',
        'veiculo.placa' => 'required|between:7,7',
        'veiculo.renavam' => 'required|between:11,11',
        'veiculo.numeroCrv' => 'required|between:10,12',
        'veiculo.codigoCrv' => 'required_if:isRenave,true|between:12,12',
        'veiculo.precoVenda' => 'required',
        'veiculo.veiculo' => 'required',
        'veiculo.hodometro' => 'required_if:isRenave,true',
        'veiculo.dataHodometro' => 'required_if:isRenave,true',
        'vendedor.email' => 'required|email',
        'vendedor.telefone' => 'required|celular_com_ddd',
        'vendedor.cpfCnpj' => 'required|cpf_ou_cnpj',
        'comprador.nome' => 'required',
        'comprador.email' => 'required|email',
        'comprador.telefone' => 'required|celular_com_ddd',
        'comprador.cpfCnpj' => 'required|cpf_ou_cnpj',
        'endereco.cep' => 'required',
        'endereco.logradouro' => 'required',
        'endereco.numero' => 'required',
        'endereco.bairro' => 'required',
        'endereco.cidade' => 'required',
        'endereco.uf' => 'required|uf',
    ];
    protected $messages = [
        'clienteId.required' => 'Selecione um Cliente.',
        'clienteId.exists' => 'Selecione um Cliente.',
        'veiculo.placa.required' => 'Obrigatório.',
        'veiculo.placa.between' => 'Placa inválida.',
        'veiculo.renavam.required' => 'Obrigatório.',
        'veiculo.renavam.between' => 'Renavam inválido.',
        'veiculo.numeroCrv.required' => 'Obrigatório.',
        'veiculo.numeroCrv.between' => 'Número CRV inválido.',
        'veiculo.codigoCrv.required_if' => 'Obrigatório.',
        'veiculo.codigoCrv.between' => 'Código CRV inválido.',
        'veiculo.precoVenda.required' => 'Obrigatório.',
        'veiculo.veiculo.required' => 'Obrigatório.',
        'veiculo.hodometro.required_if' => 'Obrigatório.',
        'veiculo.dataHodometro.required_if' => 'Obrigatório.',
        'vendedor.email.required' => 'Obrigatório.',
        'vendedor.email.email' => 'E-mail inválido.',
        'vendedor.telefone.required' => 'Obrigatório.',
        'vendedor.telefone.celular_com_ddd' => 'Telefone inválido.',
        'vendedor.cpfCnpj.required' => 'Obrigatório.',
        'vendedor.cpfCnpj.cpf_ou_cnpj' => 'CPF ou CNPJ inválido.',
        'comprador.nome.required' => 'Obrigatório.',
        'comprador.email.required' => 'Obrigatório.',
        'comprador.email.email' => 'E-mail inválido.',
        'comprador.telefone.required' => 'Obrigatório.',
        'comprador.telefone.celular_com_ddd' => 'Telefone inválido.',
        'comprador.cpfCnpj.required' => 'Obrigatório.',
        'comprador.cpfCnpj.cpf_ou_cnpj' => 'CPF ou CNPJ inválido.',
        'endereco.cep.required' => 'Obrigatório.',
        'endereco.logradouro.required' => 'Obrigatório.',
        'endereco.numero.required' => 'Obrigatório.',
        'endereco.bairro.required' => 'Obrigatório.',
        'endereco.cidade.required' => 'Obrigatório.',
        'endereco.uf.required' => 'Obrigatório.',
        'endereco.uf.uf' => 'UF inválida.',
    ];

    public function mount()
    {
        $this->clientes = \Auth::user()->despachante->clientes;
    }

    public function store()
    {
        $this->validate();

        $precoAtpv = \Auth::user()->despachante->clientes()->find($this->clienteId)->preco_atpv;
        $codigoCrv = $this->isRenave ? $this->veiculo['codigoCrv'] : null;
        $hodometro = $this->veiculo['hodometro'] ?? null;
        $dataHodometro = $this->veiculo['dataHodometro'] ?? null;

        $pedido = Pedido::create([
            'comprador_nome' => $this->comprador['nome'],
            'comprador_telefone' => $this->comprador['telefone'],
            'placa' => $this->veiculo['placa'],
            'veiculo' => $this->veiculo['veiculo'],
            'preco_honorario' => $precoAtpv,
            'status' => 'ab',
            'observacoes' => $this->observacoes,
            'criado_por' => \Auth::user()->id,
            'cliente_id' => $this->clienteId,
        ]);

        $endereco = Endereco::create([
            'logradouro' => $this->endereco['logradouro'],
            'numero' => $this->endereco['numero'],
            'bairro' => $this->endereco['bairro'],
            'cidade' => $this->endereco['cidade'],
            'estado' => $this->endereco['uf'],
            'cep' => $this->endereco['cep'],
        ]);

        $atpv = Atpv::create([
            'renavam' => $this->veiculo['renavam'],
            'numero_crv' => $this->veiculo['numeroCrv'],
            'codigo_crv' => $codigoCrv,
            'hodometro' => $hodometro,
            'data_hodometro' => $dataHodometro,
            'vendedor_email' => $this->vendedor['email'],
            'vendedor_telefone' => $this->vendedor['telefone'],
            'vendedor_cpf_cnpj' => $this->vendedor['cpfCnpj'],
            'comprador_cpf_cnpj' => $this->comprador['cpfCnpj'],
            'comprador_email' => $this->comprador['email'],
            'comprador_endereco_id' => $endereco->id,
            'preco_venda' => $this->regexMoney($this->veiculo['precoVenda']),
            'pedido_id' => $pedido->id,
        ]);


        $this->clearInputs();
        $this->emit('$refresh');
        $this->emit('success', [
            'message' => "$atpv->tipo() criado com sucesso.",
            'url' => route('despachante.atpvs.show', $pedido->numero_pedido),
        ]);
    }

    public function clearInputs()
    {
        $this->veiculo = null;
        $this->vendedor = null;
        $this->comprador = null;
        $this->endereco = null;
        $this->observacoes = null;
        $this->isRenave = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.atpv-novo');
    }
}
