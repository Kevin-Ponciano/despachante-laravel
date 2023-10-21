<?php

namespace App\Http\Livewire;

use App\Traits\FunctionsHelpers;
use App\Traits\HandinFiles;
use Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Str;

class AtpvShow extends Component
{
    use FunctionsHelpers;
    use HandinFiles;

    public $pedido;
    public $cliente;
    public $veiculo;
    public $vendedor;
    public $comprador;

    public $endereco;
    public $observacoes;
    public $precoHonorario;

    public $tipo;
    public $isRenave;
    public $isEditing = false;
    public $movimentacao;
    public $status;

    public $despachanteId;
    public $numeroCliente;
    public $numeroPedido;
    public $solicitadoCancelamento = false;
    public $servicoSC;

    public $inputPendencias = [];

    public $inputPendenciasCliente = [];

    protected $listeners = [
        '$refresh',
        'deleteFile',
    ];

    protected $rules = [
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

    public function mount($id)
    {
        $this->pedido = Auth::user()->empresa()->pedidosAtpvs()->where('numero_pedido', $id)->firstOrFail();
        $this->cliente = $this->pedido->cliente->nome;
        $this->tipo = $this->pedido->atpv->getTipo();
        switch ($this->tipo) {
            case 'RENAVE':
                $this->isRenave = true;
                $this->veiculo['codigoCrv'] = $this->pedido->atpv->codigo_crv;
                $this->movimentacao = $this->pedido->atpv->getMovimentacao();
                break;
            case 'ATPV':
                $this->isRenave = false;
                break;
        }
        $this->veiculo['placa'] = $this->pedido->placa;
        $this->veiculo['renavam'] = $this->pedido->atpv->renavam;
        $this->veiculo['numeroCrv'] = $this->pedido->atpv->numero_crv;
        $this->veiculo['hodometro'] = $this->pedido->atpv->hodometro;
        $this->veiculo['dataHodometro'] = $this->pedido->atpv->data_hodometro;
        $this->veiculo['precoVenda'] = $this->regexMoneyToView($this->pedido->atpv->preco_venda);
        $this->veiculo['veiculo'] = $this->pedido->veiculo;
        $this->vendedor['email'] = $this->pedido->atpv->vendedor_email;
        $this->vendedor['telefone'] = $this->pedido->atpv->vendedor_telefone;
        $this->vendedor['cpfCnpj'] = $this->pedido->atpv->vendedor_cpf_cnpj;
        $this->comprador['nome'] = $this->pedido->comprador_nome;
        $this->comprador['email'] = $this->pedido->atpv->comprador_email;
        $this->comprador['telefone'] = $this->pedido->comprador_telefone;
        $this->comprador['cpfCnpj'] = $this->pedido->atpv->comprador_cpf_cnpj;
        $this->endereco['cep'] = $this->pedido->atpv->compradorEndereco->cep;
        $this->endereco['logradouro'] = $this->pedido->atpv->compradorEndereco->logradouro;
        $this->endereco['numero'] = $this->pedido->atpv->compradorEndereco->numero;
        $this->endereco['bairro'] = $this->pedido->atpv->compradorEndereco->bairro;
        $this->endereco['cidade'] = $this->pedido->atpv->compradorEndereco->cidade;
        $this->endereco['uf'] = $this->pedido->atpv->compradorEndereco->estado;
        $this->observacoes = $this->pedido->observacoes;
        $this->precoHonorario = $this->regexMoneyToView($this->pedido->preco_honorario);
        $this->numeroCliente = $this->pedido->cliente->numero_cliente;
        $this->numeroPedido = $this->pedido->numero_pedido;
        $this->solicitadoCancelamento = $this->pedido->solicitado_cancelamento;
        $this->servicoSC = $this->pedido->servicos()->where('nome', 'Solicitação de Cancelamento')->first()?->toArray();
        if ($this->solicitadoCancelamento && $this->servicoSC)
            $this->servicoSC['preco'] = $this->regexMoneyToView($this->servicoSC['pivot']['preco']);

        if (Auth::user()->isDespachante())
            $this->despachanteId = Auth::user()->despachante->id;
        if (Auth::user()->isCliente()) {
            $this->inputPendenciasCliente = Arr::collapse(
                Arr::map(
                    $this->pedido->pendencias->where('tipo', 'cp')->where('status', 'pe')->toArray(),
                    function ($pendencia) {
                        return [
                            $pendencia['input'] => true
                        ];
                    }));
            if (empty($this->inputPendenciasCliente))
                $this->inputPendenciasCliente = false;
        }
    }


    public function savePrecoHonorario()
    {
        if ($this->precoHonorario == null || $this->hasConludeOrExcluded())
            return;
        $this->pedido->update([
            'preco_honorario' => $this->regexMoney($this->precoHonorario),
        ]);
        $this->emit('savedPrecoHonorario');
    }

    public function update()
    {
        if ($this->hasConludeOrExcluded())
            return;
        if ($this->isEditing || $this->inputPendenciasCliente) {
            $this->validate();

            if ($this->veiculo['dataHodometro'] === '') $this->veiculo['dataHodometro'] = null;
            if ($this->veiculo['hodometro'] === '') $this->veiculo['hodometro'] = null;

            $this->pedido->update([
                'comprador_nome' => $this->comprador['nome'],
                'comprador_telefone' => $this->comprador['telefone'],
                'placa' => Str::upper($this->veiculo['placa']),
                'veiculo' => $this->veiculo['veiculo'],
                'observacoes' => $this->observacoes,
            ]);
            $this->pedido->atpv->update([
                'renavam' => $this->veiculo['renavam'],
                'numero_crv' => $this->veiculo['numeroCrv'],
                'codigo_crv' => $this->veiculo['codigoCrv'] ?? null,
                'hodometro' => $this->veiculo['hodometro'],
                'data_hodometro' => $this->veiculo['dataHodometro'],
                'preco_venda' => $this->regexMoney($this->veiculo['precoVenda']),
                'vendedor_email' => $this->vendedor['email'],
                'vendedor_telefone' => $this->vendedor['telefone'],
                'vendedor_cpf_cnpj' => $this->vendedor['cpfCnpj'],
                'comprador_email' => $this->comprador['email'],
                'comprador_cpf_cnpj' => $this->comprador['cpfCnpj'],
            ]);
            $this->pedido->atpv->compradorEndereco->update([
                'cep' => $this->endereco['cep'],
                'logradouro' => $this->endereco['logradouro'],
                'numero' => $this->endereco['numero'],
                'bairro' => $this->endereco['bairro'],
                'cidade' => $this->endereco['cidade'],
                'estado' => $this->endereco['uf'],
            ]);

            if (Auth::user()->isDespachante()) {
                $this->isEditing = false;
                $this->emit('success', [
                    'message' => "$this->tipo atualizado com sucesso!",
                ]);
            } else {
                $this->pedido->pendencias()->where('tipo', 'cp')->where('status', 'pe')->update(['status' => 'rp']);
                $this->pedido->update(['status' => 'rp']);
                $this->pedido->timelines()->create([
                    'user_id' => Auth::user()->id,
                    'titulo' => 'Pedido retornado',
                    'descricao' => 'Pedido retornado para o despachante para análise das informações atualizadas.',
                    'tipo' => 'rp',
                ]);
                $this->emit('modal-sucesso-campos');
            }
            $camposAlterados = $this->fieldsChanged();
            if ($camposAlterados) {
                $this->pedido->timelines()->create([
                    'user_id' => Auth::user()->id,
                    'titulo' => $this->tipo . ' atualizado',
                    'descricao' => "Os campos <b>|" . $camposAlterados . "|</b> foram atualizados.",
                    'tipo' => 'up',
                    'privado' => Auth::user()->isDespachante(),
                ]);
            }
        }
    }

    protected function fieldsChanged()
    {
        $updatedFields[] = $this->pedido->getChanges();
        $updatedFields[] = $this->pedido->atpv->getChanges();
        $updatedFields[] = $this->pedido->atpv->compradorEndereco->getChanges();
        $updatedFields = Arr::collapse($updatedFields);
        $updatedFields = Arr::except($updatedFields, ['updated_at', 'criado_em', 'atualizado_em', 'concluido_em', 'deleted_at', 'status']);
        $updatedFields = Arr::map($updatedFields, function ($item, $key) {
            return match ($key) {
                'renavam' => 'Renavam',
                'numero_crv' => 'Número CRV',
                'codigo_crv' => 'Código CRV',
                'hodometro' => 'Hodômetro',
                'data_hodometro' => 'Data Hodômetro',
                'preco_venda' => 'Preço de Venda',
                'vendedor_email' => 'E-mail Vendedor',
                'vendedor_telefone' => 'Telefone Vendedor',
                'vendedor_cpf_cnpj' => 'CPF/CNPJ Vendedor',
                'comprador_email' => 'E-mail Comprador',
                'comprador_nome' => 'Nome Comprador',
                'comprador_telefone' => 'Telefone Comprador',
                'comprador_cpf_cnpj' => 'CPF/CNPJ Comprador',
                'cep' => 'CEP',
                'logradouro' => 'Logradouro',
                'numero' => 'Número',
                'bairro' => 'Bairro',
                'cidade' => 'Cidade',
                'estado' => 'UF',
                'placa' => 'Placa',
                'veiculo' => 'Veículo',
                'observacoes' => 'Observações',
                default => null,
            };
        });
        return implode(', ', $updatedFields);
    }

    public function savePrecoServico()
    {
        if ($this->servicoSC['preco'] == null || $this->hasConludeOrExcluded())
            return;
        $this->pedido->servicos()->updateExistingPivot($this->servicoSC['id'], [
            'preco' => $this->regexMoney($this->servicoSC['preco']),
        ]);
        $this->emit('savedPrecoServico');
    }

    public function solicitarCancelamento()
    {
        if ($this->status === 'ex')
            return;
        $this->solicitadoCancelamento = true;
        $this->pedido->update([
            'status' => 'sc',
            'solicitado_cancelamento' => $this->solicitadoCancelamento,
        ]);
        if (!$this->servicoSC) {
            $servico = Auth::user()->cliente->despachante->servicos()->where('nome', 'Solicitação de Cancelamento')->first();
            if (!$servico) {
                $servico = Auth::user()->cliente->despachante->servicos()->create([
                    'nome' => 'Solicitação de Cancelamento',
                    'preco' => 0,
                ]);
            }
            $this->pedido->servicos()->attach($servico->id);
            $this->servicoSC = $this->pedido->servicos()->where('nome', 'Solicitação de Cancelamento')->first()->toArray();
        }
        $this->emit('success', [
            'message' => 'Solicitação de cancelamento enviada com sucesso!',
        ]);

        $this->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Solicitação de cancelamento',
            'descricao' => Auth::user()->name . ' solicitou o cancelamento do ' . $this->tipo . '.',
            'tipo' => 'sc',
        ]);
    }

    public function storeInputPendencias()
    {
        //Todo: Pensar em outra alternativa para nao usar eventos
        $this->emit('storeInputPendencias', $this->inputPendencias);
        $this->inputPendencias = [];
    }

    public function render()
    {
        $this->status = $this->pedido->status;
        if ($this->isRenave) {
            $this->arquivosDoPedido = $this->_getFilesLink('renave/despachante');
            $this->arquivosRenave = $this->_getFilesLink('renave/cliente');
        } else
            $this->arquivosAtpvs = $this->_getFilesLink('atpv');

        return view('livewire.atpv-show');
    }
}
