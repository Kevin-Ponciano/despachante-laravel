<?php

namespace App\Http\Livewire;

use App\Models\Pendencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Component;

class Pendencias extends Component
{
    public $pendencias = [];
    public $pedidoId;
    public $name;
    public $tipo;
    public $observacao;
    public $createPendencia = false;
    public $isModal = false;

    protected $listeners = [
        '$refresh',
        'storeInputPendencias'
    ];

    public function mount()
    {
        $numeroPedido = Str::afterLast(URL::current(), '/');
        $this->pedidoId = Auth::user()->empresa()->pedidos()->where('numero_pedido', $numeroPedido)->first()->id;
    }

    public function hasPending()
    {
        $pendenciasCount = 0;
        foreach ($this->pendencias as $pendencia) {
            if ($pendencia->status != 'co')
                $pendenciasCount++;
        }
        return $pendenciasCount > 0;
    }

    public static function hasPendingStatic($pedidoId)
    {
        $pendenciasCount = Auth::user()->empresa()->pedidos()->find($pedidoId)->pendencias->where('status', '!=', 'co')->count();
        return $pendenciasCount > 0;
    }

    public function resolverPendencia($id)
    {
        if ($this->hasConludeOrExcluded())
            return;
        $pendencia = Pendencia::find($id);
        $pendencia->status = $pendencia->status == 'co' ? 'pe' : 'co';
        $pendencia->concluido_em = $pendencia->status == 'co' ? now() : null;
        $pendencia->save();
        if ($pendencia->status == 'pe') {
            if ($pendencia->pedido->status != 'pe') {
                $pendencia->pedido()->update(['status' => 'pe']);
                $this->emit('warning', 'Pedido com pendências!');
                $this->emit('$refresh');
            }
        }
    }

    public function resolverTodas()
    {
        if ($this->hasConludeOrExcluded())
            return;
        foreach ($this->pendencias as $pendencia) {
            if ($pendencia->status == 'pe' || $pendencia->status == 'rp') {
                $pendencia->status = 'co';
                $pendencia->concluido_em = now();
                $pendencia->save();
            }
        }
        $this->setPedidoAberto();
        $this->emit('$refresh');
    }

    public function store()
    {
        if ($this->hasConludeOrExcluded())
            return;
        if ($this->name == null) {
            $this->createPendencia = false;
            $this->clearFields();
            return;
        }
        $pendencia = Pendencia::create([
            'pedido_id' => $this->pedidoId,
            'nome' => $this->name,
            'tipo' => $this->tipo ?? 'dc',
            'observacao' => $this->observacao,
            'status' => 'pe',
        ]);
        if ($pendencia->pedido->status != 'pe') {
            $pendencia->pedido()->update([
                'status' => 'pe',
            ]);
            $this->emit('$refresh');
        }
        $this->createPendencia = false;
        $this->clearFields();
        $this->emit('warning', 'Pendência criada com sucesso!');
    }

    public function deletePendencia($id)
    {
        if ($this->hasConludeOrExcluded())
            return;
        Pendencia::find($id)->delete();
        $this->emit('$refresh');
    }

    public function storeInputPendencias($inputPendencias)
    {
        if ($this->hasConludeOrExcluded())
            return;
        $count = 0;
        $inputPendencias = array_reverse($inputPendencias);
        debug($inputPendencias);
        foreach ($inputPendencias as $key => $inputPendencia) {
            if ($inputPendencia) {
                $matchingPendencia = Auth::user()->empresa()->pedidos()->find($this->pedidoId)->pendencias->firstWhere('input', $key);

                $nome = match ($key) {
                    'placa' => 'A Placa do veículo está incorreta.',
                    'renavam' => 'O Renavam do veículo está incorreto.',
                    'numero_crv' => 'O Número do CRV do veículo está incorreto.',
                    'codigo_seguranca_crv' => 'O Código de Segurança do CRV do veículo está incorreto.',
                    'hodometro' => 'O Hodômetro do veículo está incorreto.',
                    'data_hora_medicao' => 'A Data/Hora de medição do Hodômetro do veículo está incorreta.',
                    'preco_venda' => 'O Preço de Venda do veículo está incorreto.',
                    'veiculo' => 'O Veículo está incorreto.',
                    'email_do_vendedor' => 'O E-mail do Vendedor está incorreto.',
                    'telefone_do_vendedor' => 'O Telefone do Vendedor está incorreto.',
                    'cpf_cnpj_do_vendedor' => 'O CPF/CNPJ do Vendedor está incorreto.',
                    'nome_do_comprador' => 'O Nome do Comprador está incorreto.',
                    'email_do_comprador' => 'O E-mail do Comprador está incorreto.',
                    'telefone_do_comprador' => 'O Telefone do Comprador está incorreto.',
                    'cpf_cnpj_do_comprador' => 'O CPF/CNPJ do Comprador está incorreto.',
                    'cep' => 'O CEP do Endereço está incorreto.',
                    'logradouro' => 'O Logradouro do Endereço está incorreto.',
                    'numero' => 'O Número do Endereço está incorreto.',
                    'bairro' => 'O Bairro do Endereço está incorreto.',
                    'cidade' => 'A Cidade do Endereço está incorreta.',
                    'uf' => 'A UF do Endereço está incorreta.',
                    default => throw new \Exception('Unexpected value'),
                };

                if (!$matchingPendencia) {
                    $p = Pendencia::create([
                        'pedido_id' => $this->pedidoId,
                        'nome' => $nome,
                        'input' => $key,
                        'observacao' => "Esta informação está incorreta, por favor corrigir.",
                        'tipo' => 'cp',
                        'status' => 'pe',
                    ]);
                    debug($p);
                } else {
                    $matchingPendencia->update([
                        'status' => 'pe',
                        'concluido_em' => null,
                    ]);
                }
                $count++;
            }
        }
        if ($count > 0) {
            Auth::user()->empresa()->pedidos()->find($this->pedidoId)->update(['status' => 'pe']);
            $this->emit('success', ['message' => 'Pendências criadas com sucesso!']);
            $this->emit('$refresh');
        } else {
            $this->emit('warning', 'Nenhuma pendência selecionada.');
        }
    }

    public function setPedidoAberto()
    {
        if ($this->hasConludeOrExcluded())
            return;
        Auth::user()->empresa()->pedidos()->find($this->pedidoId)->update(['status' => 'ab']);
        $this->emit('success', ['message' => 'Pedido em Aberto!']);
    }

    public function clearFields()
    {
        $this->name = null;
        $this->tipo = null;
        $this->observacao = null;
    }

    public function hasConludeOrExcluded()
    {
        $status = Auth::user()->empresa()->pedidos()->find($this->pedidoId)->status;
        if ($status === 'co' || $status === 'ex') {
            $this->emit('warning', 'Pedido concluído ou excluído não pode ser editado.');
            return true;
        } else {
            return false;
        }
    }

    public function render()
    {
        $this->pendencias = Auth::user()->empresa()->pedidos()->find($this->pedidoId)->pendencias->sortByDesc('id');
        return view('livewire.pendencias');
    }
}
