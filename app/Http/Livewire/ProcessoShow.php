<?php

namespace App\Http\Livewire;

use App\Models\PedidoServico;
use App\Traits\FunctionsTrait;
use App\Traits\HandinFilesTrait;
use Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProcessoShow extends Component
{
    use WithFileUploads;
    use FunctionsTrait;
    use HandinFilesTrait;

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
    public $status;
    public $arquivosDoPedido = [];
    public $arquivosCodCrlv = [];
    public $arquivoCodSeg;
    public $arquivoCrlv;


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

    protected $rulesArquivos = [
        'arquivos.*' => 'mimes:pdf|max:10240', // 10MB Max
    ];

    protected $messagesArquivos = [
        'arquivos.*.mimes' => 'Formato inválido (Somente PDF).',
        'arquivos.*.max' => 'Tamanho máximo de 10MB.',
    ];

    protected $rulesArquivoCodSeg = [
        'arquivoCodSeg' => 'mimes:pdf|max:10240', // 10MB Max
    ];

    protected $messagesArquivoCodSeg = [
        'arquivoCodSeg.mimes' => 'Formato inválido (Somente PDF).',
        'arquivoCodSeg.max' => 'Tamanho máximo de 10MB.',
    ];

    protected $rulesArquivoCrlv = [
        'arquivoCrlv' => 'mimes:pdf|max:10240', // 10MB Max
    ];

    protected $messagesArquivoCrlv = [
        'arquivoCrlv.mimes' => 'Formato inválido (Somente PDF).',
        'arquivoCrlv.max' => 'Tamanho máximo de 10MB.',
    ];

    public function updatedArquivos()
    {
        $this->validate($this->rulesArquivos, $this->messagesArquivos);
    }

    public function updatedArquivoCodSeg()
    {
        $this->validate($this->rulesArquivoCodSeg, $this->messagesArquivoCodSeg);
    }

    public function updatedArquivoCrlv()
    {
        $this->validate($this->rulesArquivoCrlv, $this->messagesArquivoCrlv);
    }


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
        $this->servicosDespachante = Auth::user()->despachante->servicos()->orderBy('nome')->get();
        $this->status = $this->pedido->status;
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

    public function getFilesLink()
    {
        $this->arquivosDoPedido = $this->_getFilesLink($this->pedido->cliente_id, $this->pedido, 'processos');
        $this->arquivosCodCrlv = $this->_getFilesLink($this->pedido->cliente_id, $this->pedido, 'cod_crlv');
    }

    public function uploadFiles($folder)
    {
        if (empty($this->arquivos)) {
            $this->addError('arquivos.*', 'Obrigatório.');
            return;
        }
        $this->arquivos = array_filter($this->arquivos, function ($file) {
            return $file != null;
        });
        $this->_uploadFiles($this->arquivos, $this->pedido->cliente_id, $this->pedido->id, $folder);
        $this->getFilesLink();
        $this->emit('success', [
            'message' => 'Arquivos enviados com sucesso.',
        ]);
    }

    public function uploadCodCrlv()
    {
        $this->_uploadCodCrlv([
            'cod' => $this->arquivoCodSeg,
            'crlv' => $this->arquivoCrlv,
        ], $this->pedido->cliente_id, $this->pedido);
        $this->getFilesLink();
        $this->emit('success', [
            'message' => 'Arquivos enviados com sucesso.',
        ]);
    }

    public function downloadFile($path)
    {
        return Storage::download($path);
    }

    public function downloadAllFiles($folder)
    {
        return $this->_downloadAllFiles($this->pedido->cliente_id, $this->pedido->id, $folder);
    }

    public function deleteFile($path)
    {
        Storage::delete($path);
        $this->arquivosDoPedido = array_filter($this->arquivosDoPedido, function ($file) use ($path) {
            return $file['path'] != $path;
        });
        $this->arquivosCodCrlv = array_filter($this->arquivosCodCrlv, function ($file) use ($path) {
            return $file['path'] != $path;
        });
        $this->emit('error', 'Arquivo deletado com sucesso.');
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
