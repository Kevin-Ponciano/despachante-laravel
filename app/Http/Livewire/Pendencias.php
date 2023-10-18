<?php

namespace App\Http\Livewire;

use App\Models\Pendencia;
use Exception;
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

    // TODO: Verificar uma forma do evento ser chamado apenas uma vez
    protected $listeners = [
        '$refresh',
        'storeInputPendencias'
    ];

    public static function hasPendingStatic($pedidoId)
    {
        $pendenciasCount = Auth::user()->empresa()->pedidos()->find($pedidoId)->pendencias->where('status', '!=', 'co')->count();
        return $pendenciasCount > 0;
    }

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

    public function resolverPendencia($id)
    {
        if ($this->hasConludeOrExcluded())
            return;
        $pendencia = Pendencia::find($id);
        $pendencia->status = $pendencia->status == 'co' ? 'pe' : 'co';
        $pendencia->concluded_at = $pendencia->status == 'co' ? now() : null;
        $pendencia->save();
        if ($pendencia->status == 'pe') {
            if ($pendencia->pedido->status != 'pe') {
                $pendencia->pedido()->update(['status' => 'pe']);
                $pendencia->pedido->timelines()->create([
                    'user_id' => Auth::user()->id,
                    'titulo' => 'Pedido pendente',
                    'descricao' => '',
                    'tipo' => 'pp',
                ]);
                $this->emit('warning', 'Pedido com pendências!');
            }
            $pendencia->pedido->timelines()->create([
                'user_id' => Auth::user()->id,
                'titulo' => 'Pendência não resolvida',
                'descricao' => "O pedido contínua com a pendência: <br><b>$pendencia->nome</b>.",
                'tipo' => 'pp',
            ]);

        } elseif ($pendencia->status == 'co') {
            $pendencia->pedido->timelines()->create([
                'user_id' => Auth::user()->id,
                'titulo' => 'Pendência resolvida',
                'descricao' => "A pendência foi resolvida: <br><b>$pendencia->nome</b>.",
                'tipo' => 'pr',
            ]);
        }
        $this->emit('$refresh');
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

    public function resolverTodas()
    {
        if ($this->hasConludeOrExcluded())
            return;
        foreach ($this->pendencias as $pendencia) {
            if ($pendencia->status !== 'co') {
                $pendencia->status = 'co';
                $pendencia->concluded_at = now();
                $pendencia->save();
            }
        }

        $this->setPedidoAberto();

        Auth::user()->empresa()->pedidos()->find($this->pedidoId)
            ->timelines()->create([
                'user_id' => Auth::user()->id,
                'titulo' => 'Pendências resolvidas',
                'descricao' => "Todas as pendências foram resolvidas.",
                'tipo' => 'pr',
            ]);
        $this->emit('$refresh');
    }

    public function setPedidoAberto()
    {
        if ($this->hasConludeOrExcluded())
            return;
        $pedido = Auth::user()->empresa()->pedidos()->find($this->pedidoId);
        $pedido->update(['status' => 'ab']);
        $pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Pedido Aberto',
            'descricao' => '',
            'tipo' => 'ap',
        ]);

        $this->emit('$refresh');
        $this->emit('success', ['message' => 'Pedido em Aberto!']);
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
            $pendencia->pedido->timelines()->create([
                'user_id' => Auth::user()->id,
                'titulo' => 'Pedido pendente',
                'descricao' => '',
                'tipo' => 'pp',
            ]);
        }

        $pendencia->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Pendência criada',
            'descricao' => "A seguinte pendência foi criada: <br><b>$pendencia->nome</b>.",
            'tipo' => 'pp',
        ]);

        $this->createPendencia = false;
        $this->emit('$refresh');
        $this->clearFields();
        $this->emit('warning', 'Pendência criada com sucesso!');
    }

    public function clearFields()
    {
        $this->name = null;
        $this->tipo = null;
        $this->observacao = null;
    }

    public function deletePendencia($id)
    {
        if ($this->hasConludeOrExcluded())
            return;
        $pendencia = Pendencia::find($id);
        $pendencia->delete();

        $pendencia->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Pendência excluída',
            'descricao' => "A seguinte pendência foi excluída: <br><b>$pendencia->nome</b>.",
            'tipo' => 'ep',
            'privado' => Auth::user()->isDespachante(),
        ]);

        $this->emit('$refresh');
    }

    public function storeInputPendencias($inputPendencias)
    {
        if ($this->hasConludeOrExcluded())
            return;
        $count = 0;
        $inputPendencias = array_reverse($inputPendencias);
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
                    default => throw new Exception('Unexpected value in Pendencias'),
                };

                if (!$matchingPendencia) {
                    Pendencia::create([
                        'pedido_id' => $this->pedidoId,
                        'nome' => $nome,
                        'input' => $key,
                        'observacao' => "Esta informação está incorreta, por favor corrigir.",
                        'tipo' => 'cp',
                        'status' => 'pe',
                    ]);
                } else {
                    $matchingPendencia->update([
                        'status' => 'pe',
                        'concluded_at' => null,
                    ]);
                }
                $count++;
            }
        }
        if ($count > 0) {
            $pedido = Auth::user()->empresa()->pedidos()->find($this->pedidoId);
            $pedido->update(['status' => 'pe']);
            $this->emit('success', ['message' => 'Pendências criadas com sucesso!']);

            $pedido->timelines()->updateOrCreate([
                'descricao' => 'Informado que alguns dados do pedido estão incorretos.',
                'created_at' => now(),
                'user_id' => Auth::user()->id,
                'titulo' => 'Pedido pendente',
                'tipo' => 'pp',
            ]);

            $this->emit('$refresh');
        } else {
            $this->emit('warning', 'Nenhuma pendência selecionada.');
        }
    }

    public function render()
    {
        $this->pendencias = Auth::user()->empresa()->pedidos()->find($this->pedidoId)->pendencias->sortByDesc('id');
        return view('livewire.pendencias');
    }
}
