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
