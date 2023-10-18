<?php

namespace App\Http\Livewire;

use App\Models\PedidoServico;
use App\Traits\FunctionsHelpers;
use App\Traits\HandinFiles;
use Arr;
use Auth;
use Livewire\Component;

class ProcessoShow extends Component
{
    use FunctionsHelpers;
    use HandinFiles;

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
    public $precoPlaca;
    public $precoHonorario;
    public $servicosDespachante = [];

    public $servicos = [];
    public $servicoId;
    public $isEditing = false;
    public $status;

    public $despachanteId;
    public $numeroCliente;
    public $numeroPedido;


    protected $listeners = [
        '$refresh',
        'deleteFile',
    ];

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
        $this->pedido = Auth::user()->empresa()->pedidosProcessos()->where('numero_pedido', $id)->firstOrFail();
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
        if (Auth::user()->isDespachante())
            $this->servicosDespachante = Auth::user()->despachante->servicos()->orderBy('nome')->get();
    }

    public function addServico()
    {
        if ($this->servicoId == null || $this->servicoId == -1 || $this->hasConludeOrExcluded())
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
            $this->pedido->timelines()->create([
                'user_id' => Auth::user()->id,
                'titulo' => 'Serviço adicionado',
                'descricao' => 'O Serviço <b>' . $servico['nome'] . '</b> foi adicionado ao processo',
                'tipo' => 'up',
                'privado' => Auth::user()->isDespachante()
            ]);
            $this->emit('savedPriceServico');
        }
    }

    public function removeServico($id)
    {
        if ($this->hasConludeOrExcluded())
            return;
        $this->servicos = array_filter($this->servicos, function ($servico) use ($id) {
            return $servico['id'] != $id;
        });
        PedidoServico::where('pedido_id', $this->pedido->id)->where('servico_id', $id)->delete();
        $this->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Serviço removido',
            'descricao' => 'O Serviço <b>' . $this->servicosDespachante->find($id)->nome . '</b> foi removido do processo',
            'tipo' => 'up',
            'privado' => Auth::user()->isDespachante()
        ]);
        $this->emit('savedPriceServico');
    }

    public function savePriceServico($index)
    {
        if ($this->hasConludeOrExcluded())
            return;
        $servico = $this->servicos[$index];
        if ($servico['preco'] == null)
            return;
        $servico['preco'] = $this->regexMoney($servico['preco']);
        PedidoServico::where('pedido_id', $this->pedido->id)->where('servico_id', $servico['id'])->update([
            'preco' => $servico['preco'],
        ]);

        $this->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Preço do serviço alterado',
            'descricao' => 'O preço do serviço <b>' . $this->servicosDespachante->find($servico['id'])->nome . '</b> foi alterado para <b>R$ ' . $this->regexMoneyToView($servico['preco']) . '</b>',
            'tipo' => 'up',
            'privado' => Auth::user()->isDespachante()
        ]);
        $this->emit('savedPriceServico');
    }

    public function savePrecoPlaca()
    {
        if ($this->precoPlaca == null || $this->hasConludeOrExcluded())
            return;
        $this->pedido->processo->update([
            'preco_placa' => $this->regexMoney($this->precoPlaca),
        ]);

        $this->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Preço da placa alterado',
            'descricao' => 'O preço da placa foi alterado para <b>R$ ' . $this->precoPlaca . '</b>',
            'tipo' => 'up',
            'privado' => Auth::user()->isDespachante()
        ]);

        $this->emit('savedPrecoPlaca');
    }

    public function savePrecoHonorario()
    {
        if ($this->precoHonorario == null || $this->hasConludeOrExcluded())
            return;
        $this->pedido->update([
            'preco_honorario' => $this->regexMoney($this->precoHonorario),
        ]);

        $this->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Preço do honorário alterado',
            'descricao' => 'O preço do honorário foi alterado para <b>R$ ' . $this->precoHonorario . '</b>',
            'tipo' => 'up',
            'privado' => Auth::user()->isDespachante()
        ]);

        $this->emit('savedPrecoHonorario');
    }

    public function update()
    {
        if (!$this->isEditing || $this->hasConludeOrExcluded())
            return;
        $this->validate();
        $this->pedido->update([
            'comprador_nome' => $this->compradorNome,
            'comprador_telefone' => $this->telefone,
            'placa' => \Str::upper($this->placa),
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

        if ($this->fieldsChanged()) {
            $this->pedido->timelines()->create([
                'user_id' => \Auth::user()->id,
                'titulo' => 'Processo atualizado',
                'descricao' => "Os campos <b>|" . $this->fieldsChanged() . "|</b> foram atualizados.",
                'tipo' => 'up',
                'privado' => Auth::user()->isDespachante(),
            ]);
        }

    }

    public function render()
    {
        $this->status = $this->pedido->status;

        $this->arquivosDoPedido = $this->_getFilesLink('processos');
        $this->arquivosCodCrlv = $this->_getFilesLink('cod_crlv');


        return view('livewire.processo-show');
    }

    protected function fieldsChanged()
    {
        $updatedFields[] = $this->pedido->getChanges();
        $updatedFields[] = $this->pedido->processo->getChanges();
        $updatedFields = Arr::collapse($updatedFields);
        $updatedFields = Arr::except($updatedFields, ['updated_at', 'criado_em', 'atualizado_em', 'concluido_em', 'deleted_at']);
        $updatedFields = Arr::map($updatedFields, function ($item, $key) {
            return match ($key) {
                'comprador_nome' => 'Nome Comprador',
                'comprador_telefone' => 'Telefone Comprador',
                'placa' => 'Placa',
                'veiculo' => 'Veículo',
                'observacoes' => 'Observações',
                'tipo' => 'Tipo de Processo',
                'comprador_tipo' => 'Tipo de Comprador',
                'qtd_placas' => 'Quantidade de Placas',
                default => null,
            };
        });

        return implode(', ', $updatedFields);
    }

}
