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
        $this->pedidoId = Auth::user()->despachante->pedidos()->where('numero_pedido', $numeroPedido)->first()->id;
    }

    public function hasPending()
    {
        $pendenciasCount = 0;
        foreach ($this->pendencias as $pendencia) {
            if ($pendencia->status == 'pe')
                $pendenciasCount++;
        }
        return $pendenciasCount > 0;
    }

    public static function hasPendingStatic($pedidoId)
    {
        $pendenciasCount = Auth::user()->despachante->pedidos()->find($pedidoId)->pendencias->where('status', 'pe')->count();
        return $pendenciasCount > 0;
    }

    public function resolverPendencia($id)
    {
        $pendencia = Pendencia::find($id);
        $pendencia->status = $pendencia->status == 'pe' ? 'co' : 'pe';
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
        foreach ($this->pendencias as $pendencia) {
            if ($pendencia->status == 'pe') {
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
            $pendencia->pedido()->update(['status' => 'pe']);
            $this->emit('$refresh');
        }
        $this->createPendencia = false;
        $this->clearFields();
        $this->emit('warning', 'Pendência criada com sucesso!');
    }

    public function deletePendencia($id)
    {
        $pendencia = Pendencia::find($id);
        $pendencia->delete();
    }

    public function storeInputPendencias($inputPendencias)
    {
        $count = 0;
        $nomePadrao = "A informação %s está incorreta";
        $inputPendencias = array_reverse($inputPendencias);
        foreach ($inputPendencias as $key => $inputPendencia) {
            if ($inputPendencia) {
                $keyFormatado = Str::of($key)->replace('_', ' ');
                $nome = sprintf($nomePadrao, Str::upper($keyFormatado));
                $matchingPendencia = $this->pendencias->firstWhere('input', $key);

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
                        'concluido_em' => null,
                    ]);
                }
                $count++;
            }
        }
        if ($count > 0) {
            Auth::user()->despachante->pedidos()->find($this->pedidoId)->update(['status' => 'pe']);
            $this->emit('success', ['message' => 'Pendências criadas com sucesso!']);
            $this->emit('$refresh');
        } else {
            $this->emit('warning', 'Nenhuma pendência selecionada.');
        }
    }

    public function setPedidoAberto()
    {
        Auth::user()->despachante->pedidos()->find($this->pedidoId)->update(['status' => 'ab']);
        $this->emit('success', ['message' => 'Pedido em Aberto!']);
    }

    public function clearFields()
    {
        $this->name = null;
        $this->tipo = null;
        $this->observacao = null;
    }

    public function render()
    {
        $this->pendencias = Auth::user()->despachante->pedidos()->find($this->pedidoId)->pendencias->sortByDesc('id');
        return view('livewire.pendencias');
    }
}
